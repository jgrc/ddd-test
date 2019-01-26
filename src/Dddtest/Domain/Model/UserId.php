<?php
declare(strict_types=1);

namespace Dddtest\Domain\Model;

use Assert\Assert;

class UserId
{
    private $id;

    private function __construct(string $id)
    {
        $this->id = $id;
    }

    public function id(): string
    {
        return $this->id;
    }

    public static function from(string $id): self
    {
        Assert::lazy()
            ->that($id, 'UserId.id')->uuid()
            ->verifyNow();

        return new self($id);
    }

    public function __toString(): string
    {
        return $this->id();
    }
}
