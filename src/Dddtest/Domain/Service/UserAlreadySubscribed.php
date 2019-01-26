<?php
declare(strict_types=1);

namespace Dddtest\Domain\Service;

use Dddtest\Domain\Model\User;

class UserAlreadySubscribed extends \Exception
{
    public static function from(User $user): self
    {
        return new self(
            \sprintf('User %s already subscribed', $user)
        );
    }
}
