<?php
declare(strict_types=1);

namespace Dddtest\Domain\Service;

use Dddtest\Domain\Model\User;
use Dddtest\Domain\Model\UserRepository;

class Subscribed
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @return User[]
     */
    public function __invoke(): array
    {
        return $this->userRepository->findAll();
    }
}
