<?php

declare(strict_types=1);

namespace App\Tests\Article\Post\Application\Query;

use App\Article\Post\Application\Query\FindPostByAuthorIdQuery;
use App\Article\Post\Application\Query\FindPostByAuthorIdQueryHandler;
use App\Article\Post\Domain\Exception\AuthorNotFoundException;
use App\Article\Post\Domain\Exception\NotPostsFoundException;
use App\Article\Post\Domain\Exception\PostRepositoryException;
use App\Article\Post\Domain\PostRepository;
use App\Shared\Domain\QueryHandlerInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

final class FindPostByAuthorIdQueryHandlerTest extends TestCase
{
    private FindPostByAuthorIdQueryHandler $sut;
    private PostRepository&MockObject $mockPostRepository;
    protected function setUp(): void
    {
        $this->mockPostRepository = $this->createMock(
            originalClassName: PostRepository::class
        );
        $this->sut = new FindPostByAuthorIdQueryHandler(
            postRepository: $this->mockPostRepository
        );
    }

    /**
     * @test
     * be_of_proper_class
     * @group find_post_by_user_id_query_handler
     */
    public function itShouldBeOfProperClass(): void
    {
        $this->assertInstanceOf(FindPostByAuthorIdQueryHandler::class, $this->sut);
        $this->assertInstanceOf(QueryHandlerInterface::class, $this->sut);
    }

    /**
     * @test
     * throw_if_user_id_not_found
     * @group find_post_by_user_id_query_handler
     */
    public function itShouldThrowIfUserIdNotFound(): void
    {
        $this->expectException(AuthorNotFoundException::class);
        $query = new FindPostByAuthorIdQuery(userId: 123);
        $this->mockPostRepository
            ->method('findPostByAuthorId')
            ->willThrowException(new AuthorNotFoundException());
        ($this->sut)($query);
    }

    /**
     * @test
     * throw_exception_if_there_are_not_posts_by_the_author
     * @group find_post_by_user_id_query_handler
     */
    public function itShouldThrowExceptionIfThereAreNotPostsByTheAuthor(): void
    {
        $this->expectException(NotPostsFoundException::class);
        $query = new FindPostByAuthorIdQuery(userId: 123);
        $this->mockPostRepository
            ->method('findPostByAuthorId')
            ->willThrowException(new NotPostsFoundException());
        ($this->sut)($query);
    }

    /**
     * @test
     * throw_exception_if_post_repository_fails
     * @group find_post_by_author_id_query_handler
     */
    public function itShouldThrowExceptionIfPostRepositoryFails(): void
    {
        $this->expectException(PostRepositoryException::class);
        $query = new FindPostByAuthorIdQuery(userId: 123);
        $this->mockPostRepository
            ->method('findPostByAuthorId')
            ->willThrowException(new PostRepositoryException());
        ($this->sut)($query);
    }
}
