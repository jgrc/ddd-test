<?php
declare(strict_types=1);

namespace Dddtest\Domain\Model;

use PHPUnit\Framework\TestCase;

class UserIdTest extends TestCase
{
    /**
     * @test
     */
    public function givenGoodUuidWhenCreateThenReturnIt(): void
    {
        $id = UserId::from('0d0450bb-41cb-4a67-845d-5117d3c7cfee');
        $this->assertEquals('0d0450bb-41cb-4a67-845d-5117d3c7cfee', (string) $id);
    }

    /**
     * @test
     */
    public function givenBadUuidWhenCreateThenThrowException(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        UserId::from('bad-uuid');
    }
}
