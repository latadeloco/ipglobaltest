<?php

declare(strict_types=1);

namespace App\Tests\Article\Post\Application\Query;

use App\Article\Post\Application\Query\FindAllArticleQuery;
use App\Article\Post\Application\Query\FindAllArticleQueryHandler;
use App\Article\Post\Domain\Exception\NotPostsFoundException;
use App\Shared\Domain\QueryHandlerInterface;
use PHPUnit\Framework\TestCase;

final class FindAllArticleQueryHandlerTest extends TestCase
{
    private FindAllArticleQueryHandler $sut;
    protected function setUp(): void
    {
        $this->sut = new FindAllArticleQueryHandler();
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
        ($this->sut)($query);
    }
}
