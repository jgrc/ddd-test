<?php
declare(strict_types=1);

namespace Dddtest\Application\Subscribe;

use Assert\Assert;

class SubscribeCommand implements \JsonSerializable
{
    private $id;
    private $email;

    protected function __construct(string $id, string $email)
    {
        $this->id = $id;
        $this->email = $email;
    }

    public function id(): string
    {
        return $this->id;
    }

    public function email(): string
    {
        return $this->email;
    }

    public static function from($id, $email): self
    {
        Assert::lazy()
            ->that($id, 'id')->uuid()
            ->that($email, 'email')->email()
            ->verifyNow();

        return new self($id, $email);
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'email' => $this->email
        ];
    }
}
