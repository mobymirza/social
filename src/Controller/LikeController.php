<?php

namespace App\Controller;

use App\Dto\LikeDto;
use App\Service\LikeService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LikeController extends AbstractController
{
    #[Route('/like', name: 'like_store',methods: 'POST')]
    public function index(Request $request,LikeService $likeService): Response
    {
        $like = $request->request->all();
        $likeDto = new LikeDto($like['user_id'],$like['post_id']);
       $likeService->save($likeDto);
        return $this->render('like/index.html.twig');
    }
}
