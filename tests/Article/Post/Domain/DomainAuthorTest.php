<?php

declare(strict_types=1);

namespace App\Tests\Article\Post\Domain;

use App\Article\Post\Domain\Author;
use App\Article\Post\Domain\AuthorAddress;
use App\Article\Post\Domain\AuthorCompany;
use App\Article\Post\Domain\AuthorContact;
use App\Article\Post\Domain\AuthorEmail;
use App\Article\Post\Domain\AuthorPhone;
use App\Article\Post\Domain\AuthorWebsite;
use App\Article\Post\Domain\DomainAuthor;
use PHPUnit\Framework\TestCase;

final class DomainAuthorTest extends TestCase
{
    /**
     * @test
     * be_of_proper_class
     * @group domain_author
     */
    public function itShouldBeOfProperClass(): void
    {

        $name = 'jesus';
        $username = 'tuli';
        $authorEmail = new AuthorEmail(email: 'jesusroblessanchez@gmail.com');
        $authorAddress = new AuthorAddress(
            street: 'Mi calle',
            city: 'Mi ciudad',
            zipcode: '111111'
        );
        $authorPhone = new AuthorPhone(
            phone: '666666666'
        );
        $authorWebsite = new AuthorWebsite(
            website: 'http://localhost'
        );
        $authorCompany = new AuthorCompany(
            name: 'my_company'
        );
        $authorContact = new AuthorContact(
            authorPhone: $authorPhone,
            authorWebsite: $authorWebsite,
            authorCompany: $authorCompany
        );
        $sut = new DomainAuthor(
            name: $name,
            username: $username,
            authorEmail: $authorEmail,
            authorAddress: $authorAddress,
            authorContact: $authorContact
        );

        $this->assertInstanceOf(DomainAuthor::class, $sut);
        $this->assertInstanceOf(Author::class, $sut);
        $this->assertEquals('jesus', $sut->name());
        $this->assertEquals('tuli', $sut->username());
        $this->assertEquals('jesusroblessanchez@gmail.com', $sut->email());
        $this->assertEquals('Mi ciudad 111111, Mi calle', $sut->address());
        $this->assertEquals('666666666', $sut->phone());
        $this->assertEquals('http://localhost', $sut->website());
        $this->assertEquals('my_company', $sut->company());
    }
}
