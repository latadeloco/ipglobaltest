<?php

declare(strict_types=1);

namespace App\Tests\Article\Post\Domain;

use App\Article\Post\Domain\AuthorPhone;
use PHPUnit\Framework\TestCase;

final class AuthorPhoneTest extends TestCase
{
    /**
     * @test
     * be_of_proper_class
     * @group author_phone
     */
    public function itShouldBeOfProperClass(): void
    {
        $sut = new AuthorPhone(phone: '666666666');
        $this->assertInstanceOf(AuthorPhone::class, $sut);
        $this->assertEquals('666666666', $sut->phone());
    }
}
