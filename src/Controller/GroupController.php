<?php

namespace App\Controller;

use App\Entity\Group;
use App\Form\GroupType;
use App\Repository\GroupRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GroupController extends AbstractController
{
    /**
     * @Route("/group", name="group")
     */
    public function showGroup(GroupRepository $groups)
    {
        $listGroups = $groups->findAll();

        return $this->render('group/show_group.html.twig', ['groups' => $listGroups]
        );
    }


    /**
     * Creates a new Group entity.
     *
     * @Route("/group/new", methods={"GET", "POST"}, name="group_new")
     *
     * NOTE: the Method annotation is optional, but it's a recommended practice
     * to constraint the HTTP methods each controller responds to (by default
     * it responds to all methods).
     */
    public function newGroup(Request $request): Response
    {
        $group = new Group();

        // See https://symfony.com/doc/current/book/forms.html#submitting-forms-with-multiple-buttons
        $form = $this->createForm(GroupType::class, $group);
        $form->handleRequest($request);

        // the isSubmitted() method is completely optional because the other
        // isValid() method already checks whether the form is submitted.
        // However, we explicitly add it to improve code readability.
        // See https://symfony.com/doc/current/best_practices/forms.html#handling-form-submits
        if ($form->isSubmitted() && $form->isValid()) {
            $group->setCreatedAt(new \DateTime());
            $group->getUser();
            $em = $this->getDoctrine()->getManager();
            $em->persist($group);
            $em->flush();

            // Flash messages are used to notify the user about the result of the
            // actions. They are deleted automatically from the session as soon
            // as they are accessed.
            // See https://symfony.com/doc/current/book/controller.html#flash-messages
            //$this->addFlash('success', 'post.created_successfully');

            return $this->redirectToRoute('group');
        }

        return $this->render('group/edit_group.html.twig', [
            'group' => $group,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Displays a form to edit an existing Group entity.
     *
     * @Route("/{id<\d+>}/group/edit", methods={"GET", "POST"}, name="group_edit")
     *
     */
    public function editGroup(Request $request, Group $group): Response
    {
        $form = $this->createForm(GroupType::class, $group);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('group');
        }

        return $this->render('group/edit_group.html.twig', [
            'group' => $group,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Deletes a Group entity.
     *
     * @Route("/{id}/group)/delete", methods={"GET", "POST"}, name="group_delete")
     *
     */
    public function deleteGroup(Group $group, ObjectManager $em): Response
    {
        $em->remove($group);
        $em->flush();

        return $this->redirectToRoute('group');
    }
}
