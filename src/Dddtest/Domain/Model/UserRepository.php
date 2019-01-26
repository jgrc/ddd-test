<?php
declare(strict_types=1);

namespace Dddtest\Domain\Model;

interface UserRepository
{
    public function add(User $user): void;
    public function findByEmail(UserEmail $email): ?User;

    /**
     * @return User[]
     */
    public function findAll(): array;
}
