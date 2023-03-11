<?php

declare(strict_types=1);

namespace App\Article\Post\Application\Query;

use App\Article\Post\Domain\Exception\NotPostsFoundException;
use App\Article\Post\Domain\Exception\PostRepositoryException;
use App\Article\Post\Domain\Post;
use App\Article\Post\Domain\PostRepository;
use App\Shared\Domain\QueryHandlerInterface;

final readonly class FindAllArticleQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private PostRepository $postRepository
    )
    {
    }

    /**
     * @throws PostRepositoryException
     * @throws NotPostsFoundException
     */
    public function __invoke(FindAllArticleQuery $query): array
    {
        $postCollection = $this->postRepository->findAll();
        return array_map(function (Post $post) {
            return PostDto::fromPost($post);
        }, $postCollection);
    }
}
