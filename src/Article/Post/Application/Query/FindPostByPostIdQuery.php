<?php

declare(strict_types=1);

namespace App\Article\Post\Application\Query;

final readonly class FindPostByAuthorIdQuery
{
    public function __construct(
        private int $userId
    )
    {
    }

    public function userId(): int
    {
        return $this->userId;
    }
}
