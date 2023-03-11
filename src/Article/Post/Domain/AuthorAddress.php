<?php

declare(strict_types=1);

namespace App\Article\Post\Domain;

final readonly class AuthorAddress
{
    public function __construct(
        private string $street,
        private string $city,
        private string $zipcode
    )
    {
    }

    public function address(): string
    {
        return $this->city . ' ' . $this->zipcode . ', ' . $this->street;
    }

    public function street(): string
    {
        return $this->street;
    }
    public function city(): string
    {
        return $this->city;
    }
    public function zipcode(): string
    {
        return $this->zipcode;
    }
}
