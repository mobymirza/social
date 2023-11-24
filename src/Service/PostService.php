<?php

namespace App\Service;

use App\Dto\PostDto;
use App\Entity\Post;
use App\Repository\PostRepository;
use App\Repository\UserRepository;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class PostService
{
    private  UserRepository $userRepository;
    private PostRepository $postRepository;
    private ImageStorage $imageStorage;
    private TelegramBot $telegramBot;

    public function __construct(UserRepository $userRepository, PostRepository $postRepository, ImageStorage $imageStorage, TelegramBot $telegramBot)
    {
        $this->userRepository = $userRepository;
        $this->postRepository = $postRepository;
        $this->imageStorage = $imageStorage;
        $this->telegramBot = $telegramBot;
    }
    /**
     * @throws TransportExceptionInterface
     */
    public function save(PostDto $postDto): void
    {
        $fileName = $this->imageStorage->uploadImage($postDto->getFile());
        $path = realpath("public/uploads/{$fileName}");
        $user = $this->userRepository->find($postDto->getUserId());
        $post = new Post($fileName,$postDto->getCaption(),$user);
        $this->postRepository->save($post);
        $this->telegramBot->sendMessage($path,$postDto->getCaption());
    }
    public function findPostsByUserId(int $userId): array
    {
      return  $this->postRepository->findPostsByUserId($userId);
    }
}