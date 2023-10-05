<?php

namespace App\Dto;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class UserRegistrationDTO
{
    private string $name;

    private UploadedFile $image;

    private string $bio;
    private string $email;
    private string $password;
    private string $user_name;

    public function __construct(string $email,string $password,string $name,UploadedFile $image,string $bio,string $user_name)
    {
        $this->email = $email;
        $this->password = $password;
        $this->name = $name;
        $this->image = $image;
        $this->bio = $bio;
        $this->user_name = $user_name;
    }

    /**
     * @return string
     */
    public function getUserName(): string
    {
        return $this->user_name;
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
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }
}