<?php

declare(strict_types=1);

namespace App\Article\Post\Domain;

use App\Article\Post\Domain\Exception\InvalidAuthorEmailException;

final readonly class AuthorEmail
{
    /**
     * @throws InvalidAuthorEmailException
     */
    public function __construct(
        private string $email
    )
    {
        $this->validateEmail($email);
    }

    public function email(): string
    {
        return $this->email;
    }

    /**
     * @throws InvalidAuthorEmailException
     */
    private function validateEmail(string $email): void
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidAuthorEmailException(
                "The email is not valid $email"
            );
        }
    }
}
