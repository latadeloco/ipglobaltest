<?php

declare(strict_types=1);

namespace App\Article\Post\Domain;

final readonly class PostId
{
    public function __construct(
        private int $id
    )
    {
    }

    public function id(): int
    {
        return $this->id;
    }
}
