<?php

declare(strict_types=1);

namespace App\Article\Post\Application\Query;

use App\Article\Autor\Domain\AuthorId;
use App\Article\Post\Domain\Exception\AuthorNotFoundException;
use App\Article\Post\Domain\PostRepository;
use App\Shared\Domain\QueryHandlerInterface;

final readonly class FindPostByAuthorIdQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private PostRepository $postRepository
    )
    {
    }

    public function __invoke(FindPostByAuthorIdQuery $query)
    {
        $postsCollection = $this->postRepository->findPostByAuthorId(new AuthorId(id: $query->userId()));

    }
}
