<?php

declare(strict_types=1);

namespace App\Tests\Article\Post\Domain;

use App\Article\Post\Domain\AuthorWebsite;
use App\Article\Post\Domain\Exception\InvalidWebsiteException;
use PHPUnit\Framework\TestCase;

final class AuthorWebsiteTest extends TestCase
{
    /**
     * @test
     * be_of_proper_class
     * @group author_website
     */
    public function itShouldBeOfProperClass(): void
    {
        $sut = new AuthorWebsite(website: 'https://libros.cc');
        $this->assertInstanceOf(AuthorWebsite::class, $sut);
        $this->assertEquals('https://libros.cc', $sut->website());
    }

    /**
     * @test
     * throw_exception_if_website_is_not_valid
     * @group author_website
     */
    public function itShouldThrowExceptionIfWebsiteIsNotValid(): void
    {
        $this->expectException(InvalidWebsiteException::class);
        new AuthorWebsite(website: 'mipatatatienepelo');
    }
}
