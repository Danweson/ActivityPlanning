<?php

namespace App\Controller;

use App\Entity\Activity;
use App\Entity\User;
use App\Form\ActivityType;
use App\Notifications\ActivitityNotification;
use App\Repository\ActivityRepository;
use Doctrine\Common\Persistence\ObjectManager;
use phpDocumentor\Reflection\Types\This;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ActivityController extends AbstractController
{

    /**
     * @var ActivitityNotification
     */
    private $notify_activity;

    public function __construct(ActivitityNotification $notify_activity)
    {
        $this->notify_activity = $notify_activity;
    }

    /**
     * @Route("/activity", name="activity")
     */
    public function showActivity(ActivityRepository $activities)
    {
        $listActivities = $activities->findAll();

        return $this->render('activity/show_activity.html.twig', ['activities' => $listActivities]
        );


    }


    /**
     * Creates a new Activity entity.
     * @Route("/activity/new", methods={"GET", "POST"}, name="activity_new")
     *
     * NOTE: the Method annotation is optional, but it's a recommended practice
     * to constraint the HTTP methods each controller responds to (by default
     * it responds to all methods).
     */
    public function newActivity(Request $request): Response
    {
        $activity = new Activity();

        // See https://symfony.com/doc/current/book/forms.html#submitting-forms-with-multiple-buttons
        $form = $this->createForm(ActivityType::class, $activity);
        $form->handleRequest($request);

        // the isSubmitted() method is completely optional because the other
        // isValid() method already checks whether the form is submitted.
        // However, we explicitly add it to improve code readability.
        // See https://symfony.com/doc/current/best_practices/forms.html#handling-form-submits
        if ($form->isSubmitted() && $form->isValid()) {
            $activity->setCreatedAt(new \DateTime());
            $activity->getUser();
            $em = $this->getDoctrine()->getManager();
            $em->persist($activity);
            $em->flush();


            // Flash messages are used to notify the user about the result of the
            // actions. They are deleted automatically from the session as soon
            // as they are accessed.
            // See https://symfony.com/doc/current/book/controller.html#flash-messages
            $this->addFlash('Message', 'Succession Activity creation !');

            return $this->redirectToRoute('activity');
        }

        return $this->render('activity/edit_activity.html.twig', [
            'activity' => $activity,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Displays a form to edit an existing Activity entity.
     *
     * @Route("/{id<\d+>}/activity/edit", methods={"GET", "POST"}, name="activity_edit")
     *
     */
    public function editActivity(Request $request, Activity $activity): Response
    {
        $form = $this->createForm(Activity::class, $activity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('activity');
        }

        return $this->render('activity/edit_activity.html.twig', [
            'activity' => $activity,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Deletes a Activity entity.
     *
     * @Route("/{id}/activity/delete", methods={"GET", "POST"}, name="activity_delete")
     *
     */
    public function deleteActivity(Activity $activity, ObjectManager $em): Response
    {
        $em->remove($activity);
        $em->flush();

        return $this->redirectToRoute('activity');
    }
}
