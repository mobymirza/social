<?php

namespace App\Service;

use App\Dto\UserRegistrationDTO;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;

class RegistrationService
{
    private UserRepository $userRepository;
    private MailerService $mailerService;
    private ImageStorage $imageStorage;

    public function __construct(UserRepository $userRepository, MailerService $mailerService, ImageStorage $imageStorage)
    {
        $this->userRepository = $userRepository;
        $this->mailerService = $mailerService;
        $this->imageStorage = $imageStorage;
    }

    /**
     * @throws TransportExceptionInterface
     * @throws \Exception
     */
    public function register(UserRegistrationDTO $userRegistrationDTO): void
    {
        if ($this->userRepository->findBy(['email' => $userRegistrationDTO->getEmail()])) {
            throw new \Exception("This email exist");
        }
       $fileName = $this->imageStorage->uploadImage($userRegistrationDTO->getImage());

        $verificationCode = mt_rand(100000, 999999);
        $password = password_hash($userRegistrationDTO->getPassword(), PASSWORD_DEFAULT);
        $user = new User($userRegistrationDTO->getEmail(), $password, $verificationCode, $userRegistrationDTO->getName(), $fileName, $userRegistrationDTO->getBio(),$userRegistrationDTO->getUserName());
        $this->mailerService->sendEmail($userRegistrationDTO->getEmail(), $verificationCode);
        $this->userRepository->save($user);
    }

    public function findProfile(int $id): ?User
    {
        return $this->userRepository->find($id);
    }
    public function verify(string $email, string $verificationCode): void
    {
        $user = $this->userRepository->findOneBy(['email' => $email]);
        if ($user === null || $user->getVerificationCode() !== $verificationCode) {
            throw  new \Exception('Invalid email or verification code');
        }
        $user->setIsVerified(true);
        $user->setVerificationCode(null);
        $this->userRepository->save($user);
    }
}