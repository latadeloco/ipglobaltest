<?php

declare(strict_types=1);

namespace App\Tests\Article\Post\Application\Query;

use App\Article\Post\Application\Query\FindPostByPostIdQuery;
use App\Article\Post\Application\Query\FindPostByPostIdQueryHandler;
use App\Article\Post\Application\Query\PostWithAuthorDto;
use App\Article\Post\Domain\Exception\AuthorNotFoundException;
use App\Article\Post\Domain\Exception\NotPostsFoundException;
use App\Article\Post\Domain\Exception\PostRepositoryException;
use App\Article\Post\Domain\Post;
use App\Article\Post\Domain\PostRepository;
use App\Shared\Domain\QueryHandlerInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

final class FindPostByPostIdQueryHandlerTest extends TestCase
{
    private FindPostByPostIdQueryHandler $sut;
    private PostRepository&MockObject $mockPostRepository;
    protected function setUp(): void
    {
        $this->mockPostRepository = $this->createMock(
            originalClassName: PostRepository::class
        );
        $this->sut = new FindPostByPostIdQueryHandler(
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
        $this->assertInstanceOf(FindPostByPostIdQueryHandler::class, $this->sut);
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
        $query = new FindPostByPostIdQuery(postId: 123);
        $this->mockPostRepository
            ->method('findPostByPostId')
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
        $query = new FindPostByPostIdQuery(postId: 123);
        $this->mockPostRepository
            ->method('findPostByPostId')
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
        $query = new FindPostByPostIdQuery(postId: 123);
        $this->mockPostRepository
            ->method('findPostByPostId')
            ->willThrowException(new PostRepositoryException());
        ($this->sut)($query);
    }

    /**
     * @test
     * happy_path
     * @group find_post_by_post_id_query_handler
     */
    public function itShouldHappyPath(): void
    {
        $query = new FindPostByPostIdQuery(postId: 123);
        $mockPost = $this->createMock(originalClassName: Post::class);
        $this->mockPostRepository
            ->method('findPostByPostId')
            ->willReturn($mockPost);
        $result = ($this->sut)($query);
        $this->assertInstanceOf(PostWithAuthorDto::class, $result);
    }
}
