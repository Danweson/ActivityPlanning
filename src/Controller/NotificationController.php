<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class NotificationController extends AbstractController
{
    /**
     * @Route("/notification", name="notification")
     */
    public function notify( \Swift_Mailer $mailer)
    {
        $name="D";
        $message = (new \Swift_Message('Activity Planning - The Deadline of Activities'))
            ->setFrom('christophedanson90@gmail.com')
            ->setTo('activityplanning1@gmail.com')
            ->setBody(
                $this->renderView(
                // templates/emails/registration.html.twig
                    'emails/activity_notification.html.twig',
                    ['name' => $name]
                ),
                'text/html'
            )

            // you can remove the following code if you don't define a text version for your emails
        ;

        $mailer->send($message);

        return $this->redirectToRoute('activity');
    }

    /**
     * @Route("/email", name="email")
     */
    public function sendEmail(MailerInterface $mailer)
    {
        $email = (new Email())
            ->from('activityplanning1@gmail.com')
            ->to('christophedanson90@gmail.com')

            ->subject('Time for Symfony Mailer!')
            ->text('Sending emails is fun again!')
            ->html('<p>See Twig integration for better HTML integration!</p>');

        $mailer->send($email);

        // ...
    }
}
