<?php

namespace App\Controller;

use App\Dto\ProfileEditDto;
use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/me', name: 'profile_edit_page', methods: 'GET')]
    public function getProfileById(UserService $userService,Request $request): Response
    {
        $id = $request->getSession()->get('user_id');
        $profileUser = $userService->findProfile($id);
        return $this->render('profile/edit.html.twig', [
            'profileUser' => $profileUser
        ]);
    }

    #[Route('/me', name: 'update_profile', methods: 'POST')]
    public function updateProfile(Request $request, UserService $userService): Response
    {
        $profileUser = $request->request->all();
        $file = $request->files->get('image');
        $profileDto = new ProfileEditDto($profileUser['id'], $profileUser['email'], $profileUser['name'], $file, $profileUser['bio']);
        $userService->updateProfile($profileDto);
        return $this->render('registration/index.html.twig');
    }
}
