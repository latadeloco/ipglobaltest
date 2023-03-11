<?php

declare(strict_types=1);

namespace App\Article\Post\Domain;

final readonly class AuthorContact
{
    public function __construct(
        private AuthorPhone $authorPhone,
        private AuthorWebsite $authorWebsite,
        private AuthorCompany $authorCompany
    )
    {
    }

    public function phone(): AuthorPhone
    {
        return $this->authorPhone;
    }
    public function website(): AuthorWebsite
    {
        return $this->authorWebsite;
    }
    public function company(): AuthorCompany
    {
        return $this->authorCompany;
    }
}
