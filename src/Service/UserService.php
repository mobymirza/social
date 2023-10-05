<?php

namespace App\Service;

use App\Dto\ProfileEditDto;
use App\Entity\User;
use App\Repository\UserRepository;
class UserService
{
    private UserRepository $userRepository;
    private ImageStorage $imageStorage;

    public function __construct(UserRepository $userRepository, ImageStorage $imageStorage)
    {
        $this->userRepository = $userRepository;
        $this->imageStorage = $imageStorage;
    }
    public function findProfile(int $id): ?User
    {
        return $this->userRepository->find($id);
    }
    public function updateProfile(ProfileEditDto $profileDto): void
    {
        $user = $this->findProfile($profileDto->getId());
        $fileName = $this->imageStorage->uploadImage($profileDto->getImage());
        $user->setEmail($profileDto->getEmail());
        $user->setName($profileDto->getName());
        $user->setImage($fileName);
        $user->setBio($profileDto->getBio());
        $this->userRepository->save($user);
    }

    public function findUser(string $user_name): ?User
    {
        return $this->userRepository->findOneBy(['user_name' => $user_name]);
    }
}