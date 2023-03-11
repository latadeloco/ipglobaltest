<?php

declare(strict_types=1);

namespace App\Tests\Article\Post\Domain;

use App\Article\Post\Domain\AuthorAddress;
use PHPUnit\Framework\TestCase;

final class AuthorAddressTest extends TestCase
{
    /**
     * @test
     * be_of_proper_class
     * @group author_address
     */
    public function itShouldBeOfProperClass(): void
    {
        $sut = new AuthorAddress(
            street: 'Calle',
            city: 'Mi ciudad',
            zipcode: '111111'
        );
        $this->assertInstanceOf(AuthorAddress::class, $sut);
        $this->assertEquals('Mi ciudad 111111, Calle', $sut->address());
    }
}
