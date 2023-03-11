<?php

declare(strict_types=1);

namespace App\Tests\Article\Post\Infrastructure\Persistence\Factory;

use App\Article\Post\Domain\DomainPost;
use App\Article\Post\Domain\Exception\InvalidDataException;
use App\Article\Post\Domain\Post;
use App\Article\Post\Domain\PostFactory;
use App\Article\Post\Infrastructure\Persistence\Factory\JsonPLaceHolderPostFactory;
use PHPUnit\Framework\TestCase;

final class JsonPlaceHolderPostFactoryTest extends TestCase
{
    private JsonPLaceHolderPostFactory $sut;
    protected function setUp(): void
    {
        $this->sut = JsonPLaceHolderPostFactory::create();
    }

    /**
     * @test
     * be_of_proper_class
     * @group json_place_holder_post_factory
     */
    public function itShouldBeOfProperClass(): void
    {
        $this->assertInstanceOf(JsonPlaceHolderPostFactory::class, $this->sut);
        $this->assertInstanceOf(PostFactory::class, $this->sut);
    }

    /**
     * @test
     * throw_exception_invalid_data_exception_if_not_all_params_are_present
     * @group json_place_holder_post_factory
     */
    public function itShouldThrowExceptionInvalidDataExceptionIfNotAllParamsArePresent(): void
    {
        $this->expectException(InvalidDataException::class);
        $this->sut->make(['title'=>'title_post']);
    }

    /**
     * @test
     * return_one_post
     * @group json_place_holder_post_factory
     */
    public function itShouldReturnOnePost(): void
    {
        $result = $this->sut->make([
            'title'=>'title_post',
            'body'=>'body_post',
            'domainAuthor' => [
                "name" => "zuli",
                "username" => "zulito",
                "email" => "jesusroblessanchez@gmail.com",
                "address" => [
                    "street" => "mi calle",
                    "city" => "mi ciudad",
                    "zipcode" => "11111"
                ],
                "phone" => "666666666",
                "website" => "localhost.com",
                "company" => [
                    "name" => "my_company"
                ]
            ]
        ]);
        $this->assertInstanceOf(Post::class, $result);
        $this->assertInstanceOf(DomainPost::class, $result);
        $this->assertEquals('title_post', $result->title());
        $this->assertEquals('body_post', $result->body());
    }
}
