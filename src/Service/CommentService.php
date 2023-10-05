<?php

namespace App\Service;

use App\Dto\CommentDto;
use App\Entity\Comments;
use App\Repository\CommentsRepository;
use App\Repository\PostRepository;
use App\Repository\UserRepository;

class CommentService
{
    private CommentsRepository $commentsRepository;
    private UserRepository $userRepository;
    private PostRepository $postRepository;
    public function __construct(CommentsRepository $commentsRepository,UserRepository $userRepository,PostRepository $postRepository)
    {
        $this->commentsRepository = $commentsRepository;
        $this->userRepository = $userRepository;
        $this->postRepository = $postRepository;
    }
    public function save(CommentDto $commentDto): void
    {
        $user = $this->userRepository->find($commentDto->getUserId());
        $post = $this->postRepository->find($commentDto->getPostId());
        $commentModel = new Comments($post,$commentDto->getComment(),$user);
        $this->commentsRepository->save($commentModel);
    }
}