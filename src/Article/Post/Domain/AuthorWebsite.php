<?php

declare(strict_types=1);

namespace App\Article\Post\Domain;

use App\Article\Post\Domain\Exception\InvalidWebsiteException;

final readonly class AuthorWebsite
{
    /**
     * @throws InvalidWebsiteException
     */
    public function __construct(
        private string $website,
    )
    {
        $this->validateWebsite(website: $website);
    }

    public function website(): string
    {
        return $this->website;
    }

    /**
     * @throws InvalidWebsiteException
     */
    private function validateWebsite(string $website): void
    {
        if (!filter_var($website, FILTER_VALIDATE_URL)) {
            throw new InvalidWebsiteException("Invalid website $website");
        }
    }
}
