<?php

declare(strict_types=1);

namespace App\Article\Post\Infrastructure\Persistence\Factory;

use App\Article\Post\Domain\Author;
use App\Article\Post\Domain\AuthorAddress;
use App\Article\Post\Domain\AuthorCompany;
use App\Article\Post\Domain\AuthorContact;
use App\Article\Post\Domain\AuthorEmail;
use App\Article\Post\Domain\AuthorPhone;
use App\Article\Post\Domain\AuthorWebsite;
use App\Article\Post\Domain\DomainAuthor;
use App\Article\Post\Domain\DomainPost;
use App\Article\Post\Domain\Exception\BodyIsEmptyException;
use App\Article\Post\Domain\Exception\InvalidAuthorEmailException;
use App\Article\Post\Domain\Exception\InvalidDataException;
use App\Article\Post\Domain\Exception\InvalidWebsiteException;
use App\Article\Post\Domain\Exception\TitleIsEmptyException;
use App\Article\Post\Domain\PostFactory;

final class JsonPLaceHolderPostFactory implements PostFactory
{
    public static function create(): self
    {
        return new self();
    }
    public function __construct()
    {
    }

    /**
     * @throws InvalidWebsiteException
     * @throws TitleIsEmptyException
     * @throws BodyIsEmptyException
     * @throws InvalidDataException
     * @throws InvalidAuthorEmailException
     */
    public function make(array $data): DomainPost
    {
        $this->validateData($data);
        $author = (JsonPlaceHolderAuthorFactory::create())->make((array)$data['domainAuthor']);
        $domainAuthor = $this->authorToDomainAuthor($author);
        return DomainPost::fromParams(
            title: (string)$data['title'],
            body: (string)$data['body'],
            domainAuthor: $domainAuthor
        );
    }

    /**
     * @throws InvalidDataException
     */
    private function validateData(array $data): void
    {
        if (!array_key_exists('title', $data)) {
            throw new InvalidDataException("The title not present in data!!!");
        }

        if (!array_key_exists('body', $data)) {
            throw new InvalidDataException("The body not present in data!!!");
        }

        if (!array_key_exists('domainAuthor', $data)) {
            throw new InvalidDataException("The domainAuthor not present in data!!!");
        }
    }

    private function authorToDomainAuthor(Author $author): DomainAuthor
    {
        $authorEmail = new AuthorEmail(email: $author->email());
        $authorAddress = new AuthorAddress(
            street: $author->street(),
            city: $author->city(),
            zipcode: $author->zipcode()
        );
        $authorPhone = new AuthorPhone(
            phone: $author->phone()
        );
        $authorWebsite = new AuthorWebsite(
            website: $author->website()
        );
        $authorCompany = new AuthorCompany(
            name: $author->company()
        );
        $authorContact = new AuthorContact(
            authorPhone: $authorPhone,
            authorWebsite: $authorWebsite,
            authorCompany: $authorCompany
        );
        return new DomainAuthor(
            name: $author->name(),
            username: $author->username(),
            authorEmail: $authorEmail,
            authorAddress: $authorAddress,
            authorContact: $authorContact
        );
    }
}
