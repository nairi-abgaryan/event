<?php

namespace AppBundle\Service\Mailer;


class MailerService
{
    /**
     * @var MailerSender
     */
    private $mailerSender;

    /**
     * @param MailerSender $mailerSender
     */
    public function __construct(MailerSender $mailerSender)
    {
        $this->mailerSender = $mailerSender;
    }

    public function sendMail($message, $email)
    {
        $this->mailerSender->send($message, $email);
    }

}
