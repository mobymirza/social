<?php

namespace App\Service;

use App\Dto\PostDto;
use App\Entity\Post;
use App\Repository\PostRepository;
use App\Repository\UserRepository;

class PostService
{
    private  UserRepository $userRepository;
    private PostRepository $postRepository;
    private ImageStorage $imageStorage;
    private Bot $bot;

    public function __construct(UserRepository $userRepository,PostRepository $postRepository,ImageStorage $imageStorage,Bot $bot)
    {
        $this->userRepository = $userRepository;
        $this->postRepository = $postRepository;
        $this->imageStorage = $imageStorage;
        $this->bot = $bot;
    }

    public function save(PostDto $postDto): void
    {
        $fileName = $this->imageStorage->uploadImage($postDto->getFile());
        $user = $this->userRepository->find($postDto->getUserId());
        $post = new Post($fileName,$postDto->getCaption(),$user);
        $this->postRepository->save($post);
    }
    public function findPostsByUserId(int $userId): array
    {
      return  $this->postRepository->findPostsByUserId($userId);
    }

}