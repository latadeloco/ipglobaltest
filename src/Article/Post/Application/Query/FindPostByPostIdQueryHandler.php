<?php

declare(strict_types=1);

namespace App\Article\Post\Application\Query;

use App\Article\Post\Domain\Exception\AuthorNotFoundException;
use App\Article\Post\Domain\Exception\NotPostsFoundException;
use App\Article\Post\Domain\Exception\PostRepositoryException;
use App\Article\Post\Domain\PostId;
use App\Article\Post\Domain\PostRepository;
use App\Shared\Domain\QueryHandlerInterface;

final readonly class FindPostByPostIdQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private PostRepository $postRepository
    )
    {
    }

    /**
     * @throws NotPostsFoundException
     * @throws PostRepositoryException
     * @throws AuthorNotFoundException
     */
    public function __invoke(FindPostByPostIdQuery $query): PostWithAuthorDto
    {
        $post = $this->postRepository->findPostByPostId(new PostId(id: $query->postId()));
        return PostWithAuthorDto::fromPost($post);
    }
}
