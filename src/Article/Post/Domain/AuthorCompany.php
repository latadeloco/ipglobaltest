<?php

declare(strict_types=1);

namespace App\Article\Post\Domain;

final readonly class AuthorCompany
{
    public function __construct(
        private string $name,
    )
    {
    }

    public function companyName(): string
    {
        return $this->name;
    }
}
