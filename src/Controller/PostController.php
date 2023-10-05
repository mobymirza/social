<?php

namespace App\Controller;

use App\Dto\PostDto;
use App\Service\PostService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostController extends AbstractController
{
    #[Route('/post/create', name: 'post_create',methods: 'GET')]
    public function index(): Response
    {
        return $this->render('post/index.html.twig');
    }
     #[Route('/post/create', name: 'post_store',methods: 'POST')]
     public  function save(Request $request,PostService $postService): RedirectResponse
     {
       $caption = $request->request->get('caption');
       $image = $request->files->get('image');
       $userId = $request->getSession()->get('user_id');
       $postDto = new PostDto($image,$caption,$userId);
       $postService->save($postDto);
       return $this->redirectToRoute('post_create');
    }
}
