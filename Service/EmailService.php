<?php

namespace App\Service;

use Swift_Mailer;

class EmailService
{
    /*private $mailer;

    public function __construct(Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
    }*/

    public function sendMail(string $message, string $email, Swift_Mailer $mailer)
    {
        $myEmail = (new Swift_Message('New Todolist'))
            ->setFrom('wassimdah@gmail.com')
            ->setTo($email)
            ->setBody($message);

        $mailer->send($myEmail);
    }
}