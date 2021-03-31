<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Controller used to manage dashboard.
 *
 */
class DashboardController extends AbstractController
{
    /**
     * @Route("/security", methods={"GET", "POST"}, name="security")
     * @Route("/interdit", methods={"GET", "POST"}, name="login")
     */
    public function securityDashboard(): Response
    {
        // We will add other queries here later

        return $this->render('dashboard/security.html.twig', []);
    }

    /**
     * @Route("/tech_seeker", methods={"GET", "POST"}, name="tech_seeker")
     */
    public function activityPlanningDashboard(): Response
    {
        // We will add other queries here later

        return $this->render('dashboard/tech_seeker.html.twig', []);
    }
}
