<?php

namespace App\Controller;
use App\Entity\Component;
use Doctrine\Common\Collections\ArrayCollection;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

/**
 * Controller used to manage user's roles in ActivityPlanning.
 */
class ActivityPlanningController extends AbstractController
{

    /**
     * @Route("/home", name="home")
     */
    public function showHome()
    {
        return $this->render('home/home.html.twig'
        );

    }

    /**
     * @Route("/account/setting", methods={"GET", "POST"}, name="account_setting")
     */
    public function componentSetting(): Response
    {
        // Get current user's profiles
        $userProfiles = $this->getUser()->getProfiles();

        // Create an array collection for user's components
        $userComponents = new ArrayCollection();

        // Load all components assigned to each profile : [profile_component] :: getComponents
        foreach ($userProfiles as $userProfile) {

            // For each user's profile get all the components
            $profileComponents = $userProfile->getComponents();

            // For each profile's component check if it is in $userComponents array collection
            foreach ($profileComponents as $profileComponent) {
                if (!$userComponents->contains($profileComponent)) {
                    $userComponents[] = $profileComponent;
                }
            }
        }


        return $this->render('activity_planning/account_setting.html.twig', [
            'userComponents' => $userComponents
        ]);
    }

    /**
     * Load one Component with all the roles.
     *
     * @Route("/{id<\d+>}/component/loading", methods={"GET", "POST"}, name="component_loading")
     *
     */
    public function componentLoading(Component $component): Response
    {
        // When click on a component
        // We want to load all the roles of that component already assign to corresponding user's profile

        // Current user
        $user = $this->getUser();

        // 1 - We can get all the user profiles : Collection
        $userProfiles = $user->getProfiles();

        // Create an array collection for all profile's roles
        $profileCollectionRoles = new ArrayCollection();

        // 2 - Then for each profile
        //   - Get its roles
        foreach ($userProfiles as $userProfile) {
            // Collection of roles
            $profileRoles = $userProfile->getRoles();

            // For each role of the current profile check if it already in the final collection
            foreach ($profileRoles as $profileRole) {

                if (!$profileCollectionRoles->contains($profileRole)) {
                    $profileCollectionRoles[] = $profileRole;
                }

            }

        }

        // Create an array collection for component's menus
        $menus = new ArrayCollection();

        // Create an array collection for component's sub menus
        $subMenus = new ArrayCollection();

        // 3 - Test to maintain only current component role
        foreach ($profileCollectionRoles as $profileCollectionRole) {

            if($profileCollectionRole->getComponent() == $component){

                if (!$profileCollectionRole->getMenu() && !$menus->contains($profileCollectionRole)) {
                    $menus[] = $profileCollectionRole;
                }

                if ($profileCollectionRole->getMenu() && !$subMenus->contains($profileCollectionRole)) {
                    $subMenus[] = $profileCollectionRole;
                }

            }
        }

        $session = new Session();

        // set menu and sub menu session attributes
        $session->set('menu', $menus);
        $session->set('submenu', $subMenus);

        /*$sessMenus = $session->get('submenu');
        foreach ($sessMenus as $sessMenu) {
            var_dump($sessMenu->getName());
        }
        die;*/

        // Get the component route
        $route = $component->getRoute();

        return $this->redirectToRoute($route);
    }
}
