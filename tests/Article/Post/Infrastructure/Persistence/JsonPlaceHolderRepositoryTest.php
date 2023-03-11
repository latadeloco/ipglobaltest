<?php

declare(strict_types=1);

namespace App\Tests\Article\Post\Infrastructure\Persistence;

use App\Article\Post\Domain\AuthorFactory;
use App\Article\Post\Domain\Exception\AuthorNotFoundException;
use App\Article\Post\Domain\Exception\PostRepositoryException;
use App\Article\Post\Domain\Post;
use App\Article\Post\Domain\PostFactory;
use App\Article\Post\Domain\PostRepository;
use App\Article\Post\Infrastructure\Persistence\JsonPlaceHolderRepository;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpClient\Exception\TransportException;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

final class JsonPlaceHolderRepositoryTest extends TestCase
{
    private JsonPlaceHolderRepository $sut;
    private HttpClientInterface&MockObject $mockClientInterface;
    private PostFactory&MockObject $mockPostFactory;

    private AuthorFactory&MockObject $mockAuthorFactory;
    protected function setUp(): void
    {
        $this->mockClientInterface = $this->createMock(
            originalClassName: HttpClientInterface::class
        );
        $this->mockPostFactory = $this->createMock(
            originalClassName: PostFactory::class
        );
        $this->mockAuthorFactory = $this->createMock(
            originalClassName: AuthorFactory::class
        );
        $this->sut = new JsonPlaceHolderRepository(
            client: $this->mockClientInterface,
            postFactory: $this->mockPostFactory,
            authorFactory: $this->mockAuthorFactory
        );

    }

    /**
     * @test
     * be_of_proper_class
     * @group json_place_holder_repository
     */
    public function itShouldBeOfProperClass(): void
    {
        $this->assertInstanceOf(JsonPlaceHolderRepository::class, $this->sut);
        $this->assertInstanceOf(PostRepository::class, $this->sut);
    }

    /**
     * @test
     * throw_exception_post_repository_exception_if_http_client_interface_fails
     * @group json_place_holder_repository
     */
    public function itShouldThrowExceptionPostRepositoryExceptionIfHttpClientInterfaceFails(): void
    {
        $this->expectException(PostRepositoryException::class);
        $this->mockClientInterface
            ->method('request')
            ->willThrowException(new TransportException());
        $this->sut->findAll();
    }

    /**
     * @test
     * throw_exception_post_respository_exception_if_response_interface_in_get_status_code
     * @group json_place_holder_repository
     */
    public function itShouldThrowExceptionPostRespositoryExceptionIfResponseInterfaceInGetStatusCode(): void
    {
        $this->expectException(PostRepositoryException::class);
        $mockResponse = $this->createMock(originalClassName: ResponseInterface::class);
        $this->mockClientInterface
            ->method('request')
            ->willReturn($mockResponse);
        $mockResponse
            ->method('getStatusCode')
            ->willThrowException(new TransportException());
        $this->sut->findAll();
    }

    /**
     * @test
     * return_array_response_when_find_all_posts
     * @group json_place_holder_repository
     */
    public function itShouldReturnArrayResponseWhenFindAllPosts(): void
    {
        $author = [
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
        ];
        $posts = [
            ['userId' => 1, 'title' => 'title_post', 'body' => 'body_post', 'domainAuthor' => $author],
            ['userId' => 1, 'title' => 'title_post', 'body' => 'body_post', 'domainAuthor' => $author],
            ['userId' => 1, 'title' => 'title_post', 'body' => 'body_post', 'domainAuthor' => $author],
            ['userId' => 1, 'title' => 'title_post', 'body' => 'body_post', 'domainAuthor' => $author],
            ['userId' => 1, 'title' => 'title_post', 'body' => 'body_post', 'domainAuthor' => $author],
            ['userId' => 1, 'title' => 'title_post', 'body' => 'body_post', 'domainAuthor' => $author],
            ['userId' => 1, 'title' => 'title_post', 'body' => 'body_post', 'domainAuthor' => $author],
        ];
        $mockResponse = $this->createMock(originalClassName: ResponseInterface::class);
        $this->mockClientInterface
            ->method('request')
            ->willReturn($mockResponse);
        $mockResponse
            ->method('toArray')
            ->willReturn($posts);
        $result = $this->sut->findAll();
        foreach ($result as $post) {
            $this->assertInstanceOf(Post::class, $post);
        }
    }

    /**
     * @test
     * throw_author_not_found_exception_when_store
     * @group json_place_holder_repository
     */
    public function itShouldThrowAuthorNotFoundExceptionWhenStore(): void
    {
        $this->expectException(AuthorNotFoundException::class);
        $this->sut->byUsername('pepito');
    }
}
