<?php

namespace App\Controller;

use App\Dto\CommentDto;
use App\Service\CommentService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommentController extends AbstractController
{
    #[Route('/comment', name: 'comment_store',methods: 'POST')]
    public function storeComment(Request $request,CommentService $commentService): Response
    {
        $user_id = $request->getSession()->get('user_id');
        $comments = $request->request->all();
        $commentDto = new CommentDto($comments['post_id'],$comments['comment'],$user_id);
        $commentService->save($commentDto);
        return $this->render('comment/index.html.twig', [
            'controller_name' => 'CommentController',
        ]);
    }
}
