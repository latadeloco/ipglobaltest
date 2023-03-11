<?php

declare(strict_types=1);

namespace App\Article\Post\Domain;

use App\Article\Post\Domain\Exception\BodyIsEmptyException;
use App\Article\Post\Domain\Exception\InvalidAuthorEmailException;
use App\Article\Post\Domain\Exception\InvalidWebsiteException;
use App\Article\Post\Domain\Exception\TitleIsEmptyException;

final class DomainPost implements Post
{
    /**
     * @throws InvalidWebsiteException
     * @throws TitleIsEmptyException
     * @throws BodyIsEmptyException
     * @throws InvalidAuthorEmailException
     */
    public static function fromParams(string $title, string $body, DomainAuthor $domainAuthor): self
    {
        return new self(
            title: $title,
            body: $body,
            domainAuthor: $domainAuthor
        );
    }

    /**
     * @throws InvalidWebsiteException
     * @throws TitleIsEmptyException
     * @throws BodyIsEmptyException
     * @throws InvalidAuthorEmailException
     */
    final private function __construct(
        private readonly string $title,
        private readonly string $body,
        private DomainAuthor $domainAuthor
    )
    {
        if ($this->title === '') {
            throw new TitleIsEmptyException("The title is empty!!");
        }
        if ($this->body === '') {
            throw new BodyIsEmptyException("The body is empty!!");
        }

        $this->linkAuthorWithPost(domainAuthor: $domainAuthor);
    }

    /**
     * @throws InvalidWebsiteException
     * @throws InvalidAuthorEmailException
     */
    private function linkAuthorWithPost(DomainAuthor $domainAuthor): void
    {
        $name = $domainAuthor->name();
        $username = $domainAuthor->username();
        $authorEmail = new AuthorEmail(email: $domainAuthor->email());
        $authorAddress = new AuthorAddress(
            street: $domainAuthor->street(),
            city: $domainAuthor->city(),
            zipcode: $domainAuthor->zipcode()
        );
        $authorPhone = new AuthorPhone(
            phone: $domainAuthor->phone()
        );
        $authorWebsite = new AuthorWebsite(
            website: $domainAuthor->website()
        );
        $authorCompany = new AuthorCompany(
            name: $domainAuthor->company()
        );
        $authorContact = new AuthorContact(
            authorPhone: $authorPhone,
            authorWebsite: $authorWebsite,
            authorCompany: $authorCompany
        );
        $this->domainAuthor = new DomainAuthor(
            name: $name,
            username: $username,
            authorEmail: $authorEmail,
            authorAddress: $authorAddress,
            authorContact: $authorContact
        );
    }
    public function title(): string
    {
        return $this->title;
    }

    public function body(): string
    {
        return $this->body;
    }

    public function link(Author $author): void
    {

    }

    public function authorName(): string
    {
        return $this->domainAuthor->name();
    }

    public function authorUsername(): string
    {
        return $this->domainAuthor->username();
    }

    public function authorEmail(): string
    {
        return $this->domainAuthor->email();
    }

    public function authorAddress(): string
    {
        return $this->domainAuthor->address();
    }

    public function authorPhone(): string
    {
        return $this->domainAuthor->phone();
    }

    public function authorWebsite(): string
    {
        return $this->domainAuthor->website();
    }

    public function authorCompany(): string
    {
        return $this->domainAuthor->company();
    }
}
