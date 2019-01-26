<?php
declare(strict_types=1);

namespace Dddtest\Domain\Util;

abstract class DomainEvent implements \JsonSerializable
{
    private $payload;
    private $ocurredOn;

    final protected function __construct(array $payload, \DateTimeInterface $ocurredOn)
    {
        $this->payload = $payload;
        $this->ocurredOn = $ocurredOn;
    }


    final public function ocurredOn(): \DateTimeInterface
    {
        return $this->ocurredOn;
    }

    final public function payload(): array
    {
        return $this->payload;
    }

    final public function jsonSerialize()
    {
        return [
            'name' => static::name(),
            'payload' => $this->payload(),
            'ocurred_on' => $this->ocurredOn()->format(\DATE_ATOM)
        ];
    }

    abstract public static function name(): string;
}
