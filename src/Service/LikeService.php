<?php

namespace App\Service;

use App\Dto\LikeDto;
use App\Entity\Like;
use App\Repository\LikeRepository;
use App\Repository\PostRepository;
use App\Repository\UserRepository;

class LikeService
{
    private  LikeRepository $likeRepository;
    private  UserRepository $userRepository;
    private PostRepository $postRepository;


    public function __construct(LikeRepository $likeRepository,UserRepository $userRepository,PostRepository $postRepository)
    {
        $this->likeRepository = $likeRepository;
        $this->userRepository = $userRepository;
        $this->postRepository = $postRepository;
    }

    /**
     * @throws \Exception
     */
    public function save(LikeDto $likeDto): void
    {
         $user = $this->userRepository->find($likeDto->getUserId());
        $post = $this->postRepository->find($likeDto->getPostId());

        $isLiked = $post->getLikes()->exists(function ($key, $like) use ($user){
            return $like->getUser()->getId() === $user->getId();
        });
      if (!$isLiked){
          $modelLike = new Like($user,$post);
          $this->likeRepository->save($modelLike);
       }
      else{
          throw  new \Exception("You have already liked");
      }


    }
}





