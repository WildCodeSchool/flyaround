<?php

/**
 * Mailer service file
 *
 * PHP Version 7.1
 *
 * @category Service
 * @package  Service
 * @author   Gaëtan Rolé-Dubruille <gaetan@wildcodeschool.fr>
 */

namespace AppBundle\Service;

use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Mailer class service.
 *
 * @category Service
 * @package  Service
 * @author   Gaëtan Rolé-Dubruille <gaetan@wildcodeschool.fr>
 */

class Mailer
{
    protected $mailer;

    protected $templating;

    /**
     * Constructor getting dependency injection
     */
    public function __construct(\Swift_Mailer $mailer, \Twig_Environment $templating)
    {
        $this->mailer     = $mailer;
        $this->templating = $templating;
    }

    /**
     * Send an email with recipients
     *
     * @param string $fromEmail     Sender's email
     * @param string $toEmail       Receiver's email
     * @param string $recipientName Receiver's name
     * @param string $subject       Email's subject
     * @param string $message       Email's body
     *
     * @return int The number of successful recipients. Can be 0 which indicates failure
     */
    public function sendEmail($fromEmail, $toEmail, $recipientName, $subject, $message)
    {
        // If your service is another, then read the following article
        // to know which smpt code to use and which port
        // http://ourcodeworld.com/articles/read/14/swiftmailer-send-mails-from-php-easily-and-effortlessly
        // https://myaccount.google.com/lesssecureapps

        $message = \Swift_Message::newInstance()
            ->setSubject($subject)
            ->setFrom($fromEmail)
            ->setCharset('UTF-8')
            ->setTo($toEmail)
            ->setBody(
                $this->templating->render(
                    'email/contact.html.twig',
                    array('name' => $recipientName,
                        'subject' => $subject,
                        'message' => $message
                    )
                ),
                'text/html'
            );

        return $this->mailer->send($message);
    }
}
