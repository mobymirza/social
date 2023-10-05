<?php

namespace App\Controller;

use App\Service\FollowingService;
use App\Service\LikeService;
use App\Service\PostService;
use App\Service\RegistrationService;
use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FollowingController extends AbstractController
{
    #[Route('/follow', name: 'add_follower', methods: 'Post')]
    public function following(Request $request, FollowingService $followingService): RedirectResponse
    {
        $following = $request->request->get('id');
        $follower = $request->getSession()->get('user_id');
        $followingService->follow($following, $follower);
        return $this->redirect("$following");
    }

    /**
     * @throws \Exception
     */
    #[Route('/{user_name}', name: 'show_profile', methods: 'GET')]
    public function show(RegistrationService $registrationService, FollowingService $followingService, Request $request,UserService $userService,PostService $postService,LikeService $likeService): Response
    {
        $followerId = $request->getSession()->get('user_id');
        $userName = $request->attributes->get('user_name');
        $followingId = $userService->findUser($userName)->getId();
        $isFollowed = $followingService->isFollowed($followerId, $followingId);
        $profileUser = $registrationService->findProfile($followingId);
        $posts = $postService->findPostsByUserId($followingId);
        return $this->render('profile/show.html.twig', [
            'profileUser' => $profileUser,
            'isFollowed' => $isFollowed,
            'posts' => $posts,
        ]);
    }

    /**
     * @throws \Exception
     */
    #[Route('/unfollow', name: 'unfollow', methods: 'POST')]

    public function  unfollow(Request $request,FollowingService $followingService): RedirectResponse
    {
        $following = $request->request->get('id');
        $follower = $request->getSession()->get('user_id');
        $followingService->unFollow($follower, $following);
        return $this->redirect("$following");
    }
}
