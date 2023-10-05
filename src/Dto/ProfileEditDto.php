<?php

namespace App\Dto;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class ProfileEditDto
{
    private  int $id;
    private string $email;
    private string $name;
    private UploadedFile $image;
    private string $bio;

    public function __construct(int $id,string $email,string $name,UploadedFile $image,string $bio)
    {
        $this->id = $id;
        $this->email = $email;
        $this->name = $name;
        $this->image = $image;
        $this->bio = $bio;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return UploadedFile
     */
    public function getImage(): UploadedFile
    {
        return $this->image;
    }
    /**
     * @return string
     */
    public function getBio(): string
    {
        return $this->bio;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }
}