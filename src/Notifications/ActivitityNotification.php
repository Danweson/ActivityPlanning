<?php

namespace App\Notifications;

// On importe les classes nécessaires à l'envoi d'e-mail et à twig

use App\Controller\ActivityController;
use App\Entity\Activity;
use App\Entity\User;
use App\Repository\ActivityRepository;
use Swift_Message;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class ActivitityNotification
{
    /**
     * Propriété contenant le module d'envoi de mails
     * 
     * @var \Swift_Mailer
     */
    private $mailer;

    /**
     * Propriété contenant l'environnement Twig
     *
     * @var Environment
     */
    private $renderer;

    public function __construct(\Swift_Mailer $mailer, Environment $renderer)
    {
        $this->mailer = $mailer;
        $this->renderer = $renderer;
    }

    /**
     * Méthode de notification (envoi de mail)
     *
     * @return void
     */
    public function notify(User $user)
    {
        //$activity = new Activity();
        //$deadlineDate = new \DateTime();
       // $activityDate = $activity->getStartDate();
       // if (new \DateTime($activityDate)) {

                $activity = new Activity();

            // On construit le mail
            $message = (new Swift_Message('Activity Planning - The Deadline of Activities'))
                // Expéditeur
                ->setFrom('christophedanson90@gmail.com')
                // Destinataire
                ->setTo($user->getEmail())
                // Corps du message
                ->setBody(
                    $this->renderer->render(

                        'emails/activity_notification.html.twig',[$activity->getContent()]
                    ),
                    'text/html'
                );

            // On envoie le mail
            $this->mailer->send($message);

        }
   // }
}