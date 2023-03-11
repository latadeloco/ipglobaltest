<?php

declare(strict_types=1);

namespace App\Article\Autor\Domain;

final class AuthorId
{
    public function __construct(
        private readonly int $id
    )
    {
    }

    public function id(): int
    {
        return $this->id;
    }
}
