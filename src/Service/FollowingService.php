<?php

namespace App\Service;

use App\Entity\User;
use App\Repository\UserRepository;
class FollowingService
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function follow(int $followingId, int $followerId): void
    {
        $following = $this->userRepository->find($followingId);
        $follower = $this->userRepository->find($followerId);
        $user = $follower->addFollowing($following);
        $this->userRepository->save($user);
    }

    /**
     * @throws \Exception
     */
    public function isFollowed(int $followerId, int $followingId): bool
    {
        $follower = $this->userRepository->find($followerId);
        if (is_null($follower)){
            throw new \Exception("This follower does not exist");
        }
        $following = $this->userRepository->find($followingId);
        if (is_null($following)){
            throw new \Exception("This following does not exist");
        }
        return $follower->getFollowings()->contains($following);
    }
    public function unFollow(int $followerId, int $followingId): void
    {
        $following = $this->userRepository->find($followingId);
        $follower = $this->userRepository->find($followerId);
        $follower->removeFollowing($following);
        $this->userRepository->save($follower);
    }
}