<?php

declare(strict_types=1);

namespace App\Article\Post\Application\Command;

use App\Article\Post\Domain\Author;
use App\Article\Post\Domain\AuthorAddress;
use App\Article\Post\Domain\AuthorCompany;
use App\Article\Post\Domain\AuthorContact;
use App\Article\Post\Domain\AuthorEmail;
use App\Article\Post\Domain\AuthorPhone;
use App\Article\Post\Domain\AuthorRepository;
use App\Article\Post\Domain\AuthorWebsite;
use App\Article\Post\Domain\DomainAuthor;
use App\Article\Post\Domain\DomainPost;
use App\Article\Post\Domain\Exception\InvalidAuthorEmailException;
use App\Article\Post\Domain\Exception\InvalidWebsiteException;
use App\Article\Post\Domain\PostRepository;
use App\Shared\Domain\CommandHandlerInterface;

final readonly class CreatePostCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private AuthorRepository $authorRepository,
        private PostRepository   $postRepository
    )
    {
    }

    public function __invoke(CreatePostCommand $command)
    {
        $author = $this->authorRepository->byUsername($command->username());
        $domainAuthor = $this->authorToDomainAuthor($author);
        $post = DomainPost::fromParams($command->title(), $command->body(), domainAuthor: $domainAuthor);
        $post->link($author);
        $this->postRepository->store($post);
    }

    /**
     * @throws InvalidWebsiteException
     * @throws InvalidAuthorEmailException
     */
    private function authorToDomainAuthor(Author $author): DomainAuthor
    {
        $authorEmail = new AuthorEmail(
            email: $author->email()
        );
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
