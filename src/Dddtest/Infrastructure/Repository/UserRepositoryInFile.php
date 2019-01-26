<?php
declare(strict_types=1);

namespace Dddtest\Infrastructure\Repository;

use Dddtest\Domain\Model\User;
use Dddtest\Domain\Model\UserEmail;
use Dddtest\Domain\Model\UserRepository;

class UserRepositoryInFile implements UserRepository
{
    private $file;
    private $data;

    public function __construct(string $file)
    {
        $this->file = $file;
        $this->data = \file_exists($this->file) ? @\unserialize(\file_get_contents($this->file)) : [];
    }

    public function add(User $user): void
    {
        $this->data[] = $user;
        \file_put_contents($this->file, \serialize($this->data));
    }

    public function findByEmail(UserEmail $email): ?User
    {
        /** @var User $user */
        foreach ($this->data as $user) {
            if ($user->email()->equalTo($email)) {
                return $user;
            }
        }

        return null;
    }

    public function findAll(): array
    {
        return $this->data;
    }
}
