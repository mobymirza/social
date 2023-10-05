<?php

namespace App\Dto;

class LikeDto
{
    private  int $user_id;
    private int $post_id;
    public function __construct(int $user_id,int $post_id)
    {
        $this->user_id = $user_id;
        $this->post_id = $post_id;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->user_id;
    }

    /**
     * @return int
     */
    public function getPostId(): int
    {
        return $this->post_id;
    }
}