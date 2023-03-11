<?php

declare(strict_types=1);

namespace App\Tests\Article\Post\Domain;

use App\Article\Post\Domain\AuthorAddress;
use App\Article\Post\Domain\AuthorCompany;
use App\Article\Post\Domain\AuthorContact;
use App\Article\Post\Domain\AuthorEmail;
use App\Article\Post\Domain\AuthorPhone;
use App\Article\Post\Domain\AuthorWebsite;
use App\Article\Post\Domain\DomainAuthor;
use App\Article\Post\Domain\DomainPost;
use App\Article\Post\Domain\Exception\BodyIsEmptyException;
use App\Article\Post\Domain\Exception\TitleIsEmptyException;
use App\Article\Post\Domain\Post;
use PHPUnit\Framework\TestCase;

final class DomainPostTest extends TestCase
{
    /**
     * @test
     * be_of_proper_class
     * @group domain_post
     */
    public function itShouldBeOfProperClass(): void
    {
        $sut = DomainPost::fromParams(title: 'title_post', body: 'body_post',domainAuthor: DomainPostOM::createRandomAuthor());
        $this->assertInstanceOf(DomainPost::class, $sut);
        $this->assertInstanceOf(Post::class, $sut);
        $this->assertEquals('title_post', $sut->title());
        $this->assertEquals('body_post', $sut->body());
    }

    /**
     * @test
     * vinculate_author_to_the_post
     * @group domain_post
     */
    public function itShouldVinculateAuthorToThePost(): void
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
        $domainAuthor = new DomainAuthor(
            name: $name,
            username: $username,
            authorEmail: $authorEmail,
            authorAddress: $authorAddress,
            authorContact: $authorContact
        );
        $sut = DomainPost::fromParams(title: 'title_post', body: 'body_post', domainAuthor: $domainAuthor);
        $sut->link($domainAuthor);
        $this->assertEquals('jesus', $sut->authorName());
        $this->assertEquals('tuli', $sut->authorUsername());
        $this->assertEquals('jesusroblessanchez@gmail.com', $sut->authorEmail());
        $this->assertEquals('Mi ciudad 111111, Mi calle', $sut->authorAddress());
        $this->assertEquals('666666666', $sut->authorPhone());
        $this->assertEquals('http://localhost', $sut->authorWebsite());
        $this->assertEquals('my_company', $sut->authorCompany());
    }

    /**
     * @test
     * throw_exception_if_title_is_empty
     * @group domain_post
     */
    public function itShouldThrowExceptionIfTitleIsEmpty(): void
    {
        $this->expectException(TitleIsEmptyException::class);
        DomainPost::fromParams(title: '', body: 'body_post', domainAuthor: DomainPostOM::createRandomAuthor());
    }

    /**
     * @test
     * throw_exception_if_body_is_empty
     * @group domain_post
     */
    public function itShouldThrowExceptionIfBodyIsEmpty(): void
    {
        $this->expectException(BodyIsEmptyException::class);
        DomainPost::fromParams(title: 'title_post', body: '', domainAuthor: DomainPostOM::createRandomAuthor());
    }
}
