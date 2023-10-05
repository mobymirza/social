<?php

namespace App\Controller;

use App\Dto\UserDto;
use App\Service\AuthorizationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AuthorizationController extends AbstractController
{
    #[Route('/login', name: 'app_login', methods: 'GET')]
    public function showLogin(): Response
    {
        return $this->render('login/index.html.twig');
    }

    /**
     * @throws \Exception
     */
    #[Route('/login', name: 'login', methods: 'POST')]
    public function loginUser(AuthorizationService $loginService, Request $request): Response
    {
        $user = $request->request->all();
        $userLoginDto = new UserDto($user['email'], $user['password']);
        $loginService->loginUser($userLoginDto);
        return $this->render('login/welcome.html.twig');
    }

    #[Route('/logout', name: 'logout',methods: 'GET')]
    public function logOutUser(AuthorizationService $loginService): Response
    {
        $loginService->logOutUser();
        return $this->render('log_out/index.html.twig');
    }
}
