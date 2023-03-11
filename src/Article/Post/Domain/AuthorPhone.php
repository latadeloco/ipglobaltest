<?php

declare(strict_types=1);

namespace App\Article\Post\Domain;

final readonly class AuthorPhone
{
    public function __construct(
        private string $phone
    )
    {
    }

    public function phone(): string
    {
        return $this->phone;
    }
}
