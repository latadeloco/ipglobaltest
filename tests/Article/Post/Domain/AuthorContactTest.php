<?php

declare(strict_types=1);

namespace App\Tests\Article\Post\Domain;

use App\Article\Post\Domain\AuthorCompany;
use App\Article\Post\Domain\AuthorContact;
use App\Article\Post\Domain\AuthorPhone;
use App\Article\Post\Domain\AuthorWebsite;
use PHPUnit\Framework\TestCase;

final class AuthorContactTest extends TestCase
{
    /**
     * @test
     * be_of_proper_class
     * @group author_contact
     */
    public function itShouldBeOfProperClass(): void
    {
        $authorPhone = new AuthorPhone(phone: '666666666');
        $authorWebsite = new AuthorWebsite(website: 'http://localhost');
        $authorCompany = new AuthorCompany(name: 'Mi copañia');
        $sut = new AuthorContact(
            authorPhone: $authorPhone,
            authorWebsite: $authorWebsite,
            authorCompany: $authorCompany
        );
        $this->assertInstanceOf(AuthorContact::class, $sut);
        $this->assertEquals('666666666', $sut->phone()->phone());
        $this->assertEquals('http://localhost', $sut->website()->website());
        $this->assertEquals('Mi copañia', $sut->company()->companyName());
    }
}
