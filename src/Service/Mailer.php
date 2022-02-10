<?php

namespace App\Service;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;

class Mailer
{
    private $mailer;

    private $from;

    public function __construct(MailerInterface $mailer, $from)
    {

        $this->mailer = $mailer;
        $this->from = $from;
    }

    public function sendEmail($subject, $toMail, $view, $variables): string
    {

        if (!filter_var($toMail, FILTER_VALIDATE_EMAIL)) {
            return "Failed";
        }
        $email = (new TemplatedEmail())
            ->from($this->from)
            ->to($variables[1])
            ->subject($subject)
            ->htmlTemplate("emails/" . $view . ".html.twig")
            ->context(['data' => $variables]);
        try {
            dd($email);
            $this->mailer->send($email);
            return "Success";
        } catch (TransportExceptionInterface $e) {
            return "Failed : " . $e->getMessage();
        }
    }
}
