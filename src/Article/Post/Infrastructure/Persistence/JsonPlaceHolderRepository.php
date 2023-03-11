<?php

declare(strict_types=1);

namespace App\Article\Post\Infrastructure\Persistence;

use App\Article\Post\Domain\Author;
use App\Article\Post\Domain\AuthorFactory;
use App\Article\Post\Domain\AuthorRepository;
use App\Article\Post\Domain\Exception\AuthorNotFoundException;
use App\Article\Post\Domain\Exception\NotPostsFoundException;
use App\Article\Post\Domain\Exception\PostRepositoryException;
use App\Article\Post\Domain\Post;
use App\Article\Post\Domain\PostFactory;
use App\Article\Post\Domain\PostId;
use App\Article\Post\Domain\PostRepository;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

final readonly class JsonPlaceHolderRepository implements PostRepository, AuthorRepository
{
    public function __construct(
        private HttpClientInterface $client,
        private PostFactory $postFactory,
        private AuthorFactory $authorFactory
    )
    {
    }

    public function findAll(): array
    {
        $postsCollection = $this->request(method: 'GET', uri: 'https://jsonplaceholder.typicode.com/posts');
        if (empty($postsCollection)) {
            throw new NotPostsFoundException("Not posts found!!!");
        }
        return array_map(function (array $post) {
            $author = $this->findAuthorDataOfPostId((int)$post['userId']);
            $post['domainAuthor'] = $author;
            return $this->postFactory->make($post);
        }, $postsCollection);
    }

    public function findPostByPostId(PostId $postId): Post
    {
        $jsonPost = $this->request(method: 'GET', uri: 'https://jsonplaceholder.typicode.com/posts/' . $postId->id());
        if (empty($jsonPost)) {
            throw new NotPostsFoundException("Not post found!!!");
        }
        $authorId = (int)$jsonPost['userId'];
        $author = $this->findAuthorDataOfPostId(authorId: $authorId);
        $jsonPost['domainAuthor'] = $author;
        return $this->postFactory->make($jsonPost);
    }

    private function findAuthorDataOfPostId(int $authorId): array
    {
        return $this->request(method: 'GET', uri: 'https://jsonplaceholder.typicode.com/users/' . $authorId);
    }

    /**
     * @throws PostRepositoryException
     */
    private function request(string $method, string $uri): array
    {
        try {
            $response = $this->client->request(
                $method,
                $uri
            );
            $this->statusCode($response);
            return $this->content($response);
        } catch (
            ClientExceptionInterface
        |RedirectionExceptionInterface
        |ServerExceptionInterface
        |TransportExceptionInterface
        |DecodingExceptionInterface $e) {
            throw new PostRepositoryException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * @throws TransportExceptionInterface
     */
    private function statusCode(ResponseInterface $response): void
    {
        $response->getStatusCode();
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    private function content(ResponseInterface $response): array
    {
        return $response->toArray();
    }

    public function store(Post $post): void
    {
    }

    /**
     * @throws PostRepositoryException
     * @throws AuthorNotFoundException
     */
    public function byUsername(string $name): Author
    {
        $postsCollection = $this->request(
            method: 'GET',
            uri: 'https://jsonplaceholder.typicode.com/posts'
        );
        $usersIds = $this->findAllUserId($postsCollection);
        return $this->findUsername($usersIds, $name);
    }

    private function findAllUserId(array $postCollection): array
    {
        $usersId = [];
        /** @var array $post */
        foreach ($postCollection as $post) {
            array_push($usersId, (int)$post['userId']);
        }
        return array_values(array_unique($usersId));
    }

    /**
     * @throws PostRepositoryException
     * @throws AuthorNotFoundException
     */
    private function findUsername(array $userIds, string $name): Author
    {
        /** @var int $userId */
        foreach ($userIds as $userId) {
            $response = $this->request(
                method: 'GET',
                uri: 'https://jsonplaceholder.typicode.com/users/' . $userId
            );
            $author = $this->authorFactory->make($response);
            if ($name === $author->username()) {
                return $author;
            }
        }
        throw new AuthorNotFoundException("The author $name is not found!!!");
    }
}
