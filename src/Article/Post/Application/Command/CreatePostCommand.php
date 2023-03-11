<?php

declare(strict_types=1);

namespace App\Article\Post\Application\Command;

final readonly class CreatePostCommand
{
    public function __construct(
        private string $title,
        private string $body,
        private string $username,
    )
    {
    }

    public function title(): string
    {
        return $this->title;
    }

    public function body(): string
    {
        return $this->body;
    }

    public function username(): string
    {
        return $this->username;
    }
}
