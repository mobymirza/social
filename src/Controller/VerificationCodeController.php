<?php

namespace App\Controller;

use App\Service\RegistrationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VerificationCodeController extends AbstractController
{
    /**
     * @throws \Exception
     */
    #[Route('/verify', name: 'verify',methods: 'POST')]
    public function verify(RegistrationService $registrationService, Request $request): Response
    {
        $email = $request->query->get('email');
        $verificationCode = $request->query->get('code');
        $registrationService->verify($email, $verificationCode);

        return $this->render('verification_code/index.html.twig');
    }
}
