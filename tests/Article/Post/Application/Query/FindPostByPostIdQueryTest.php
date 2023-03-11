<?php

declare(strict_types=1);

namespace App\Tests\Article\Post\Application\Query;

use App\Article\Post\Application\Query\FindPostByPostIdQuery;
use PHPUnit\Framework\TestCase;

final class FindPostByPostIdQueryTest extends TestCase
{
    /**
     * @test
     * be_of_proper_class
     * @group find_post_by_user_id_query
     */
    public function itShouldBeOfProperClass(): void
    {
        $sut = new FindPostByPostIdQuery(userId: 123);
        $this->assertInstanceOf(FindPostByPostIdQuery::class, $sut);
        $this->assertEquals(123, $sut->userId());
    }
}
