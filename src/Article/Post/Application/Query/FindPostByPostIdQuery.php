<?php

declare(strict_types=1);

namespace App\Article\Post\Application\Query;

final readonly class FindPostByPostIdQuery
{
    public function __construct(
        private int $postId
    )
    {
    }

    public function postId(): int
    {
        return $this->postId;
    }
}
