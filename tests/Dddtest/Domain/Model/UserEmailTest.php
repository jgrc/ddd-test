<?php
declare(strict_types=1);

namespace Dddtest\Domain\Model;

use PHPUnit\Framework\TestCase;

class UserEmailTest extends TestCase
{
    /**
     * @test
     */
    public function givenGoodEmailWhenCreationThenReturnIt(): void
    {
        $email = UserEmail::from('available@example.com');
        $this->assertEquals('available@example.com', (string) $email);
    }

    /**
     * @test
     */
    public function givenBadEmailWhenCreationThenThrowException(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        UserEmail::from('bad-email');
    }

    /**
     * @test
     */
    public function givenTwoDiferentEmailsWhenCompareThenReturnFalse(): void
    {
        $email = UserEmail::from('available@example.com');
        $anotherEmail = UserEmail::from('other@example.com');

        $this->assertFalse($email->equalTo($anotherEmail));
    }

    /**
     * @test
     */
    public function givenEqualEmailsWhenCompareThenReturnTrue(): void
    {
        $email = UserEmail::from('available@example.com');
        $sameEmail = UserEmail::from('available@example.com');

        $this->assertTrue($email->equalTo($sameEmail));
    }
}
