<?php

declare(strict_types=1);

namespace App\Tests\Article\Post\Application\Query;

use App\Article\Post\Application\Query\FindAllArticleQuery;
use PHPUnit\Framework\TestCase;

final class FindAllArticleQueryTest extends TestCase
{
    /**
     * @test
     * be_of_proper_class
     * @group find_all_article_query
     */
    public function itShouldBeOfProperClass(): void
    {
        $sut = new FindAllArticleQuery();
        $this->assertInstanceOf(FindAllArticleQuery::class, $sut);
    }
}
