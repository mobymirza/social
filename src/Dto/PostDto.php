<?php

namespace App\Dto;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class PostDto
{
    private UploadedFile $file;

    private string $caption;
    private int $userId;

    public function __construct(UploadedFile $file, string $caption, int $userId)
    {
        $this->file = $file;
        $this->caption = $caption;
        $this->userId = $userId;
    }

    /**
     * @return UploadedFile
     */
    public function getFile(): UploadedFile
    {
        return $this->file;
    }

    /**
     * @return string
     */
    public function getCaption(): string
    {
        return $this->caption;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }


}