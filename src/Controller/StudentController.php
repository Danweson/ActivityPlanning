<?php

namespace App\Controller;

use App\Entity\Student;
use App\Form\StudentType;
use App\Repository\StudentRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StudentController extends AbstractController
{
    /**
     * @Route("/student", name="student")
     */
    public function showStudent(StudentRepository $students)
    {
        $listStudents = $students->findAll();

        return $this->render('student/show_student.html.twig', ['students' => $listStudents]
        );
    }


    /**
     * Creates a new Role entity.
     *
     * @Route("/student/new", methods={"GET", "POST"}, name="student_new")
     *
     * NOTE: the Method annotation is optional, but it's a recommended practice
     * to constraint the HTTP methods each controller responds to (by default
     * it responds to all methods).
     */
    public function newStudent(Request $request): Response
    {
       $student = new Student();

        // See https://symfony.com/doc/current/book/forms.html#submitting-forms-with-multiple-buttons
        $form = $this->createForm(StudentType::class, $student);
        $form->handleRequest($request);

        // the isSubmitted() method is completely optional because the other
        // isValid() method already checks whether the form is submitted.
        // However, we explicitly add it to improve code readability.
        // See https://symfony.com/doc/current/best_practices/forms.html#handling-form-submits
        if ($form->isSubmitted() && $form->isValid()) {
            $student->setCreatedAt(new \DateTime());
            $em = $this->getDoctrine()->getManager();
            $em->persist($student);
            $em->flush();

            // Flash messages are used to notify the user about the result of the
            // actions. They are deleted automatically from the session as soon
            // as they are accessed.
            // See https://symfony.com/doc/current/book/controller.html#flash-messages
            //$this->addFlash('success', 'post.created_successfully');

            return $this->redirectToRoute('student');
        }

        return $this->render('student/edit_student.html.twig', [
            'student' => $student,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Displays a form to edit an existing Student entity.
     *
     * @Route("/{id<\d+>}/student/edit", methods={"GET", "POST"}, name="student_edit")
     *
     */
    public function editStudent(Request $request,Student $student): Response
    {
        $form = $this->createForm(StudentType::class, $student);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('student');
        }

        return $this->render('student/edit_student.html.twig', [
            'student' => $student,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Deletes a Student entity.
     *
     * @Route("/{id}/student/delete", methods={"GET", "POST"}, name="student_delete")
     *
     */
    public function deleteStudent(Student $student, ObjectManager $em): Response
    {
        $em->remove($student);
        $em->flush();

        return $this->redirectToRoute('student');
    }
}
