<?php

namespace App\Dto;

class UserDto
{
   private string $email;

    private string $password;

    public function __construct(string $email,string $password)
    {
        $this->email = $email;
        $this->password = $password;
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