<?php
declare(strict_types=1);

namespace Dddtest\Domain\Service;

use Dddtest\Domain\Model\User;
use Dddtest\Domain\Model\UserRepository;

class Subscribe
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function __invoke(User $user): void
    {
        $userSubscribed = $this->userRepository->findByEmail($user->email());

        if (null !== $userSubscribed) {
            throw UserAlreadySubscribed::from($user);
        }

        $this->userRepository->add($user);
    }
}
