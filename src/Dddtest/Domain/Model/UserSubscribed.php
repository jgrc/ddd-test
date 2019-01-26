<?php
declare(strict_types=1);

namespace Dddtest\Domain\Model;

use Dddtest\Domain\Util\Clock;
use Dddtest\Domain\Util\DomainEvent;

class UserSubscribed extends DomainEvent
{
    public static function name(): string
    {
        return 'ddd_test.user.subscribed';
    }

    public static function from(User $user): self
    {
        return new self(
            [
                'user' => $user
            ],
            Clock::now()
        );
    }
}
