<?php

namespace App\Controller;

use App\Entity\Profile;
use App\Form\ProfileType;
use App\Repository\ProfileRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfileController extends AbstractController
{
    /**
     * @Route("/profile", name="profile")
     */
    public function showProfile(ProfileRepository $profiles)
    {
        $listProfiles = $profiles->findAll();

        return $this->render('profile/show_profile.html.twig', ['profiles' => $listProfiles]
        );
    }


    /**
     * Creates a new Profile entity.
     *
     * @Route("/profile/new", methods={"GET", "POST"}, name="profile_new")
     *
     * NOTE: the Method annotation is optional, but it's a recommended practice
     * to constraint the HTTP methods each controller responds to (by default
     * it responds to all methods).
     */
    public function newProfile(Request $request): Response
    {
        $profile = new Profile();

        // See https://symfony.com/doc/current/book/forms.html#submitting-forms-with-multiple-buttons
        $form = $this->createForm(ProfileType::class, $profile);
        $form->handleRequest($request);

        // the isSubmitted() method is completely optional because the other
        // isValid() method already checks whether the form is submitted.
        // However, we explicitly add it to improve code readability.
        // See https://symfony.com/doc/current/best_practices/forms.html#handling-form-submits
        if ($form->isSubmitted() && $form->isValid()) {
            $profile->setCreatedAt(new \DateTime());
            $profile->getUser();
            $em = $this->getDoctrine()->getManager();
            $em->persist($profile);
            $em->flush();

            // Flash messages are used to notify the user about the result of the
            // actions. They are deleted automatically from the session as soon
            // as they are accessed.
            // See https://symfony.com/doc/current/book/controller.html#flash-messages
            //$this->addFlash('success', 'post.created_successfully');

            return $this->redirectToRoute('profile');
        }

        return $this->render('profile/edit_profile.html.twig', [
            'profile' => $profile,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Displays a form to edit an existing Profile entity.
     * @Route("/{id<\d+>}/profile/edit", methods={"GET", "POST"}, name="profile_edit")
     *
     */
    public function editProfile(Request $request, Profile $profile): Response
    {
        $form = $this->createForm(ProfileType::class, $profile);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('profile');
        }

        return $this->render('profile/edit_profile.html.twig', [
            'profile' => $profile,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Deletes a Profile entity.
     *
     * @Route("/{id}/profile)/delete", methods={"GET", "POST"}, name="profile_delete")
     *
     */
    public function deleteProfile(Profile $profile, ObjectManager $em): Response
    {
        $em->remove($profile);
        $em->flush();

        return $this->redirectToRoute('profile');
    }
}
