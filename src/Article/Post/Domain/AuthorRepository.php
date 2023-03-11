<?php

declare(strict_types=1);

namespace App\Article\Post\Domain;

use App\Article\Post\Domain\Exception\AuthorNotFoundException;

interface AuthorRepository
{
    /**
     * @throws AuthorNotFoundException
     */
    public function byUsername(string $name): Author;
}
