<?php
declare(strict_types=1);

namespace Dddtest\Domain\Model;

use Dddtest\Domain\Util\Clock;
use PHPUnit\Framework\TestCase;

class UserSubscribedTest extends TestCase
{
    /**
     * @test
     */
    public function givenUserWhenCreateThenReturnIt(): void
    {
        $user = User::subscribe(
            UserId::from('0d0450bb-41cb-4a67-845d-5117d3c7cfee'),
            UserEmail::from('available@example.com')
        );
        $now = new \DateTimeImmutable('2019-01-01 00:01:02', new \DateTimeZone('UTC'));
        Clock::setFakeNow($now);
        $event = UserSubscribed::from($user);
        $this->assertEquals(['user' => $user], $event->payload());
        $this->assertEquals($now, $event->ocurredOn());
        $this->assertEquals('ddd_test.user.subscribed', $event::name());
    }
}
