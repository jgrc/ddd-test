<?php
declare(strict_types=1);

namespace Dddtest\Domain\Model;

use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    /**
     * @test
     */
    public function givenIdAndEmailWhenSubscribeThenReturnIt(): void
    {
        $user = User::subscribe(
            UserId::from('0d0450bb-41cb-4a67-845d-5117d3c7cfee'),
            UserEmail::from('available@example.com')
        );

        $this->assertEquals('0d0450bb-41cb-4a67-845d-5117d3c7cfee', (string) $user->id());
        $this->assertEquals('available@example.com', (string) $user->email());
        $this->assertCount(1, $user->events());
        $this->assertInstanceOf(UserSubscribed::class, $user->events()[0]);
    }
}
