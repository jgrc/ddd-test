<?php
declare(strict_types=1);

namespace Dddtest\Domain\Service;

use Dddtest\Domain\Model\User;
use Dddtest\Domain\Model\UserEmail;
use Dddtest\Domain\Model\UserId;
use Dddtest\Domain\Model\UserRepository;
use PHPUnit\Framework\TestCase;

class SubscribeTest extends TestCase
{
    private $userRepository;

    public function setUp()
    {
        $this->userRepository = $this->createMock(UserRepository::class);
    }

    /**
     * @test
     */
    public function givenUserWhenSubscribeThenSaveIt(): void
    {
        $user = User::subscribe(
            UserId::from('0d0450bb-41cb-4a67-845d-5117d3c7cfee'),
            UserEmail::from('available@example.com')
        );

        $this->userRepository
            ->expects($this->once())
            ->method('findByEmail')
            ->willReturn(null);

        $this->userRepository
            ->expects($this->once())
            ->method('add')
            ->with($user)
            ->willReturn(null);

        (new Subscribe($this->userRepository))($user);
    }

    /**
     * @test
     */
    public function givenSubscribedUserWhenSubscribeThenThrowException(): void
    {
        $this->expectException(UserAlreadySubscribed::class);
        $user = User::subscribe(
            UserId::from('0d0450bb-41cb-4a67-845d-5117d3c7cfee'),
            UserEmail::from('available@example.com')
        );

        $this->userRepository
            ->expects($this->once())
            ->method('findByEmail')
            ->willReturn($user);

        (new Subscribe($this->userRepository))($user);
    }
}
