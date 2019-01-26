<?php
declare(strict_types=1);

namespace Dddtest\Domain\Service;

use Dddtest\Domain\Model\UserRepository;
use PHPUnit\Framework\TestCase;

class SubscribedTest extends TestCase
{
    private $userRepository;

    public function setUp()
    {
        $this->userRepository = $this->createMock(UserRepository::class);
    }

    /**
     * @test
     */
    public function whenRecoverSupscriptionsThenReturnIt(): void
    {
        $this->userRepository
            ->expects($this->once())
            ->method('findAll')
            ->willReturn([]);

        $this->assertEquals([], (new Subscribed($this->userRepository))());
    }
}
