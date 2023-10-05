<?php

namespace App\Dto;

class CommentDto
{
    private int $post_id;

   private string $comment;

   private int $user_id;

   public function __construct(int $post_id,string $comment,int $user_id)
   {
       $this->post_id = $post_id;
       $this->comment = $comment;
       $this->user_id = $user_id;
   }

    /**
     * @return int
     */
    public function getPostId(): int
    {
        return $this->post_id;
    }

    /**
     * @return string
     */
    public function getComment(): string
    {
        return $this->comment;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->user_id;
    }
}