<?php
declare(strict_types=1);

namespace Dddtest\Application\Subscribe;

use PHPUnit\Framework\TestCase;

class SubscribeCommandTest extends TestCase
{
    /**
     * @test
     */
    public function givenUuidAndEmailWhenCreateThenReturnIt(): void
    {
        $command = SubscribeCommand::from('0d0450bb-41cb-4a67-845d-5117d3c7cfee', 'available@example.com');
        $this->assertEquals('0d0450bb-41cb-4a67-845d-5117d3c7cfee', $command->id());
        $this->assertEquals('available@example.com', $command->email());
    }

    /**
     * @test
     */
    public function givenBadUuidAndEmailWhenCreateThenThrowException(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        SubscribeCommand::from('bad-uuid', 'available@example.com');
    }

    /**
     * @test
     */
    public function givenUuidAndBadEmailWhenCreateThenThrowException(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        SubscribeCommand::from('0d0450bb-41cb-4a67-845d-5117d3c7cfee', 'bad-email');
    }
}
