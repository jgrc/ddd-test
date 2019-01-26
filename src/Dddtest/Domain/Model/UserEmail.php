<?php
declare(strict_types=1);

namespace Dddtest\Domain\Model;

use Assert\Assert;

class UserEmail
{
    private $address;

    private function __construct(string $address)
    {
        Assert::lazy()
            ->that($address, 'UserEmail.address')->email()
            ->verifyNow();

        $this->address = $address;
    }

    public static function from(string $address): self
    {
        return new self($address);
    }

    public function address(): string
    {
        return $this->address;
    }

    public function equalTo(UserEmail $other): bool
    {
        return $other->address() === $this->address();
    }

    public function __toString(): string
    {
        return $this->address();
    }
}
