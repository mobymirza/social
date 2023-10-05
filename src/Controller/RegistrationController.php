<?php

namespace App\Controller;

use App\Dto\UserRegistrationDTO;
use App\Service\RegistrationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'registration_page', methods: 'GET')]
    public function showRegistration(): Response
    {
        return $this->render('registration/index.html.twig');
    }

    /**
     * @throws TransportExceptionInterface
     */
    #[Route('/register', name: 'register', methods: 'POST')]
    public function register(Request $request, RegistrationService $registrationService): Response
    {
        $user = $request->request->all();
        $file = $request->files->get('image');
        $userRegistrationDto = new UserRegistrationDTO($user['email'], $user['password'], $user['name'], $file, $user['bio'],$user['user_name']);
        $registrationService->register($userRegistrationDto);
        return $this->render('registration/index.html.twig');
    }
}
