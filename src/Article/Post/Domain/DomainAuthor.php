<?php

declare(strict_types=1);

namespace App\Article\Post\Domain;

final readonly class DomainAuthor implements Author
{
    public function __construct(
        private string $name,
        private string $username,
        private AuthorEmail $authorEmail,
        private AuthorAddress $authorAddress,
        private AuthorContact $authorContact
    )
    {
    }

    public function name(): string
    {
        return $this->name;
    }

    public function username(): string
    {
        return $this->username;
    }

    public function email(): string
    {
        return $this->authorEmail->email();
    }

    public function address(): string
    {
        return $this->authorAddress->address();
    }

    public function street(): string
    {
        return $this->authorAddress->street();
    }
    public function city(): string
    {
        return $this->authorAddress->city();
    }
    public function zipcode(): string
    {
        return $this->authorAddress->zipcode();
    }

    public function phone(): string
    {
        return $this->authorContact->phone()->phone();
    }

    public function website(): string
    {
        return $this->authorContact->website()->website();
    }

    public function company(): string
    {
        return $this->authorContact->company()->companyName();
    }
}
