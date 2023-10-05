<?php

namespace App\Service;

use App\Dto\UserDto;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class AuthorizationService
{
    private UserRepository $registrationRepository;
    private SessionInterface $session;

    public function __construct(UserRepository $registrationRepository, SessionInterface $session)
    {
        $this->registrationRepository = $registrationRepository;
        $this->session = $session;
    }

    /**
     * @throws \Exception
     */
    public function loginUser(UserDto $userDto): void
    {
        $user = $this->registrationRepository->findOneBy(['email' => $userDto->getEmail()]);
        if (!$user) {
            throw  new \Exception('There is no such user');
        }
        if ($user->isIsVerified() == null) {
            throw  new \Exception('First the user`s email must be verified');
        }
        if (!password_verify($userDto->getPassword(), $user->getPassword())) {
            throw new \Exception('Your password is incorrect');
        }
         $this->session->set('user_id', $user->getId());
    }

    public function logOutUser(): void
    {
        $this->session->remove('user_id');
    }
}