<?php
declare(strict_types=1);

namespace Dddtest\Domain\Model;

use Dddtest\Domain\Util\DomainModel;

class User implements DomainModel
{
    private $id;
    private $email;
    private $events;

    private function __construct(UserId $id, UserEmail $email)
    {
        $this->id = $id;
        $this->email = $email;
        $this->events = [];
    }

    public static function subscribe(UserId $id, UserEmail $email): self
    {
        $user = new User($id, $email);
        $user->events[] = UserSubscribed::from($user);

        return $user;
    }

    public function id(): UserId
    {
        return $this->id;
    }

    public function email(): UserEmail
    {
        return $this->email;
    }

    public function events(): array
    {
        return $this->events;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id()->id(),
            'email' => $this->email()->address()
        ];
    }

    public function __toString(): string
    {
        return (string) $this->email();
    }
}
