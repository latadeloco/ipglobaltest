<?php

declare(strict_types=1);

namespace App\Article\Post\Application\Query;

use App\Article\Post\Domain\Post;

final class PostDto
{
    public static function fromPost(Post $post): self
    {
        return new self(
            title: $post->title(),
            body: $post->body()
        );
    }

    private function __construct(
        public string $title,
        public string $body
    )
    {
    }
}
