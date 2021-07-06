<?php

namespace App\Service;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;



class Mailer 
{
    /**
     * @var MailerInterface
     */
    private $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendEmail($email, $token)
    {
        $email = (new TemplatedEmail())
            ->from('snowtricks@example.com')
            ->to(new Address($email))
            ->subject('Snowtriks - Valider votre compte !')

            // path of the Twig template to render
            ->htmlTemplate('emails/validate.html.twig')

            // pass variables (name => value) to the template
            ->context([
                'token' => $token,
            ])
        ;

        $this->mailer->send($email);
    }
}