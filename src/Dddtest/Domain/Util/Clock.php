<?php
declare(strict_types=1);

namespace Dddtest\Domain\Util;

class Clock
{
    private static $fakeNow;

    public static function setFakeNow(\DateTimeInterface $fakeNow): void
    {
        self::$fakeNow = $fakeNow;
    }

    public static function now(): \DateTimeInterface
    {
        return self::$fakeNow ?? new \DateTimeImmutable('now');
    }
}
