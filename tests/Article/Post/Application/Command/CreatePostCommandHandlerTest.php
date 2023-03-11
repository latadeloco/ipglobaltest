<?php

declare(strict_types=1);

namespace App\Tests\Article\Post\Application\Command;

use App\Article\Post\Application\Command\CreatePostCommand;
use App\Article\Post\Application\Command\CreatePostCommandHandler;
use App\Article\Post\Domain\Author;
use App\Article\Post\Domain\AuthorAddress;
use App\Article\Post\Domain\AuthorCompany;
use App\Article\Post\Domain\AuthorContact;
use App\Article\Post\Domain\AuthorEmail;
use App\Article\Post\Domain\AuthorPhone;
use App\Article\Post\Domain\AuthorRepository;
use App\Article\Post\Domain\AuthorWebsite;
use App\Article\Post\Domain\DomainAuthor;
use App\Article\Post\Domain\Exception\AuthorNotFoundException;
use App\Article\Post\Domain\Exception\PostRepositoryException;
use App\Article\Post\Domain\PostRepository;
use App\Shared\Domain\CommandHandlerInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

final class CreatePostCommandHandlerTest extends TestCase
{
    private CreatePostCommandHandler $sut;
    private AuthorRepository&MockObject $mockAuthorRepository;
    private PostRepository&MockObject $mockPostRepository;
    protected function setUp(): void
    {
        $this->mockAuthorRepository = $this->createMock(
            originalClassName: AuthorRepository::class
        );
        $this->mockPostRepository = $this->createMock(
            originalClassName: PostRepository::class
        );
        $this->sut = new CreatePostCommandHandler(
            authorRepository: $this->mockAuthorRepository,
            postRepository: $this->mockPostRepository
        );
    }

    /**
     * @test
     * be_of_proper_class
     * @group create_post_command_handler
     */
    public function itShouldBeOfProperClass(): void
    {
        $this->assertInstanceOf(CreatePostCommandHandler::class, $this->sut);
        $this->assertInstanceOf(CommandHandlerInterface::class, $this->sut);
    }

    /**
     * @test
     * throw_exception_if_username_not_found
     * @group create_post_command_handler
     */
    public function itShouldThrowExceptionIfUsernameNotFound(): void
    {
        $this->expectException(AuthorNotFoundException::class);
        $command = new CreatePostCommand(title: 'title', body: 'body', username: 'pepito');
        $this->mockAuthorRepository
            ->method('byUsername')
            ->willThrowException( new AuthorNotFoundException());
        ($this->sut)($command);
    }

    /**
     * @test
     * throw_exception_if_post_repository_fails
     * @group create_post_command_handler
     */
    public function itShouldThrowExceptionIfPostRepositoryFails(): void
    {
        $this->expectException(PostRepositoryException::class);
        $command = new CreatePostCommand(title: 'title', body: 'body', username: 'pepito');
        $author = $this->createAuthor();
        $this->mockAuthorRepository
            ->method('byUsername')
            ->willReturn($author);
        $this->mockPostRepository
            ->method('store')
            ->willThrowException(new PostRepositoryException());
        ($this->sut)($command);
    }

    /**
     * @test
     * happy_path
     * @group create_post_command_handler
     */
    public function itShouldHappyPath(): void
    {
        $command = new CreatePostCommand(title: 'title', body: 'body', username: 'pepito');
        $author = $this->createAuthor();
        $this->mockAuthorRepository
            ->method('byUsername')
            ->willReturn($author);
        $this->mockPostRepository
            ->expects($this->atLeast(1))
            ->method('store');
        ($this->sut)($command);
    }

    private function createAuthor(): Author
    {
        $authorEmail = new AuthorEmail(
            email: 'jesusroblessanchez@gmail.com'
        );
        $authorAddress = new AuthorAddress(
            street: 'Mi calle',
            city: 'Mi ciudad',
            zipcode: '111111'
        );
        $authorPhone = new AuthorPhone(phone: '666666666');
        $authorWebsite = new AuthorWebsite(website: 'http://localhost');
        $authorCompany = new AuthorCompany(name: 'my_company');
        $authorContact = new AuthorContact(
            authorPhone: $authorPhone,
            authorWebsite: $authorWebsite,
            authorCompany: $authorCompany
        );
        return new DomainAuthor(
            name: 'jesus',
            username: 'zulito',
            authorEmail: $authorEmail,
            authorAddress: $authorAddress,
            authorContact: $authorContact
        );
    }
}
