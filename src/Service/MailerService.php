<?php

namespace App\Service;

use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class MailerService
{
    private MailerInterface $mailer;
    private UrlGeneratorInterface $urlGenerator;

    public function __construct(MailerInterface $mailer, UrlGeneratorInterface $urlGenerator)
    {
        $this->mailer = $mailer;
        $this->urlGenerator = $urlGenerator;
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function sendEmail(string $email, string $verificationCode): void
    {
        $url = $this->urlGenerator->generate('verify', ['code' => $verificationCode, 'email' => $email], UrlGeneratorInterface::ABSOLUTE_URL);

        $email = (new Email())
            ->from('your@email.com')
            ->to($email)
            ->subject('Time for Symfony Mailer!')
            ->html("Sending emails is! <a href='{$url}'>Verify</a>");
        $this->mailer->send($email);
    }
}