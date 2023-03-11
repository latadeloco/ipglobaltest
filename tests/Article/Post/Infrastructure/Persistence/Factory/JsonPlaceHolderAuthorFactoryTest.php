<?php

declare(strict_types=1);

namespace App\Tests\Article\Post\Infrastructure\Persistence\Factory;

use App\Article\Post\Domain\Author;
use App\Article\Post\Domain\AuthorFactory;
use App\Article\Post\Domain\Exception\InvalidDataException;
use App\Article\Post\Infrastructure\Persistence\Factory\JsonPlaceHolderAuthorFactory;
use PHPUnit\Framework\TestCase;

final class JsonPlaceHolderAuthorFactoryTest extends TestCase
{
    /**
     * @test
     * be_of_proper_class
     * @group json_place_holder_author_factory
     */
    public function itShouldBeOfProperClass(): void
    {
        $sut = JsonPlaceHolderAuthorFactory::create();
        $this->assertInstanceOf(JsonPlaceHolderAuthorFactory::class, $sut);
        $this->assertInstanceOf(AuthorFactory::class, $sut);
    }

    /**
     * @test
     * throw_exception_invalid_data_exception_if_not_all_params_are_present
     * @group json_place_holder_author_factory
     */
    public function itShouldThrowExceptionInvalidDataExceptionIfNotAllParamsArePresent(): void
    {
        $this->expectException(InvalidDataException::class);
        $sut = JsonPlaceHolderAuthorFactory::create();
        $sut->make([
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
            ]
        ]);
    }

    /**
     * @test
     * return_author
     * @group json_place_holder_author_factory
     */
    public function itShouldReturnAuthor(): void
    {
        $sut = JsonPlaceHolderAuthorFactory::create();
        $result = $sut->make([
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
        ]);
        $this->assertInstanceOf(Author::class, $result);
    }
}
