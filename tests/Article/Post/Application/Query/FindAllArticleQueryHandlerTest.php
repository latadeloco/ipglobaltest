<?php

declare(strict_types=1);

namespace App\Tests\Article\Post\Application\Query;

use App\Article\Post\Application\Query\FindAllArticleQuery;
use App\Article\Post\Application\Query\FindAllArticleQueryHandler;
use App\Article\Post\Application\Query\PostDto;
use App\Article\Post\Domain\Exception\NotPostsFoundException;
use App\Article\Post\Domain\Exception\PostRepositoryException;
use App\Article\Post\Domain\PostRepository;
use App\Shared\Domain\QueryHandlerInterface;
use App\Tests\Article\Post\Domain\DomainPostOM;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

final class FindAllArticleQueryHandlerTest extends TestCase
{
    private FindAllArticleQueryHandler $sut;
    private PostRepository&MockObject $mockPostRepository;
    protected function setUp(): void
    {
        $this->mockPostRepository = $this->createMock(
            originalClassName: PostRepository::class
        );
        $this->sut = new FindAllArticleQueryHandler(
            postRepository: $this->mockPostRepository
        );
    }

    /**
     * @test
     * be_of_proper_class
     * @group find_all_article_query_handler
     */
    public function itShouldBeOfProperClass(): void
    {
        $this->assertInstanceOf(FindAllArticleQueryHandler::class, $this->sut);
        $this->assertInstanceOf(QueryHandlerInterface::class, $this->sut);
    }

    /**
     * @test
     * throw_exception_if_not_posts_found
     * @group find_all_article_query_handler
     */
    public function itShouldThrowExceptionIfNotPostsFound(): void
    {
        $this->expectException(NotPostsFoundException::class);
        $query = new FindAllArticleQuery();
        $this->mockPostRepository
            ->method('findAll')
            ->willThrowException(new NotPostsFoundException());
        ($this->sut)($query);
    }

    /**
     * @test
     * throw_exception_if_post_repository_fails
     * @group find_all_article_query_handler
     */
    public function itShouldThrowExceptionIfPostRepositoryFails(): void
    {
        $this->expectException(PostRepositoryException::class);
        $query = new FindAllArticleQuery();
        $this->mockPostRepository
            ->method('findAll')
            ->willThrowException(new PostRepositoryException());
        ($this->sut)($query);
    }

    /**
     * @test
     * happy_path
     * @group find_all_article_query_handler
     */
    public function itShouldHappyPath(): void
    {
        $domainPosts = DomainPostOM::twoPost();
        $query = new FindAllArticleQuery();
        $this->mockPostRepository
            ->method('findAll')
            ->willReturn($domainPosts);
        $result = ($this->sut)($query);
        $this->assertIsArray($result);
        $this->assertInstanceOf(PostDto::class, $result[0]);
        $this->assertInstanceOf(PostDto::class, $result[1]);
        $this->assertEquals('title_post_one', $result[0]->title);
        $this->assertEquals('body_post_one', $result[0]->body);
        $this->assertEquals('title_post_two', $result[1]->title);
        $this->assertEquals('body_post_two', $result[1]->body);
    }
}
