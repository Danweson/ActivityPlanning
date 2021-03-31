<?php

namespace App\Controller;

use App\Entity\Role;
use App\Form\RoleType;
use App\Repository\RoleRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RoleController extends AbstractController
{
    /**
     * @Route("/role", name="role")
     */
    public function showRole(RoleRepository $roles)
    {
        $listRoles = $roles->findAll();

        return $this->render('role/show_role.html.twig', ['roles' => $listRoles]
        );
    }


    /**
     * Creates a new Role entity.
     *
     * @Route("/role/new", methods={"GET", "POST"}, name="role_new")
     *
     * NOTE: the Method annotation is optional, but it's a recommended practice
     * to constraint the HTTP methods each controller responds to (by default
     * it responds to all methods).
     */
    public function newRole(Request $request): Response
    {
        $role = new Role();

        // See https://symfony.com/doc/current/book/forms.html#submitting-forms-with-multiple-buttons
        $form = $this->createForm(RoleType::class, $role);
        $form->handleRequest($request);

        // the isSubmitted() method is completely optional because the other
        // isValid() method already checks whether the form is submitted.
        // However, we explicitly add it to improve code readability.
        // See https://symfony.com/doc/current/best_practices/forms.html#handling-form-submits
        if ($form->isSubmitted() && $form->isValid()) {
            $role->setCreatedAt(new \DateTime());
            $role->getUser();
            $em = $this->getDoctrine()->getManager();
            $em->persist($role);
            $em->flush();

            // Flash messages are used to notify the user about the result of the
            // actions. They are deleted automatically from the session as soon
            // as they are accessed.
            // See https://symfony.com/doc/current/book/controller.html#flash-messages
            //$this->addFlash('success', 'post.created_successfully');

            return $this->redirectToRoute('role');
        }

        return $this->render('role/edit_role.html.twig', [
            'role' => $role,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Displays a form to edit an existing Role entity.
     *
     * @Route("/{id<\d+>}/role/edit", methods={"GET", "POST"}, name="role_edit")
     *
     */
    public function editCategory(Request $request, Role $role): Response
    {
        $form = $this->createForm(RoleType::class, $role);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('role');
        }

        return $this->render('role/edit_role.html.twig', [
            'role' => $role,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Deletes a Role entity.
     *
     * @Route("/{id}/role/delete", methods={"GET", "POST"}, name="role_delete")
     *
     */
    public function deleteCategory(Role $role, ObjectManager $em): Response
    {
        $em->remove($role);
        $em->flush();

        return $this->redirectToRoute('role');
    }
}
