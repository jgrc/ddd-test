<?php
declare(strict_types=1);

namespace Dddtest\Application\Subscribed;

class SubscribedQuery implements \JsonSerializable
{
    private function __construct()
    {
    }

    public static function create(): self
    {
        return new self();
    }

    public function jsonSerialize(): array
    {
        return [];
    }
}
