<?php

declare(strict_types=1);

namespace App\Article\Post\Application\Query;

use App\Article\Post\Domain\Post;

final class PostWithAuthorDto
{
    public static function fromPost(Post $post): self
    {
        return new self(
            title: $post->title(),
            body: $post->body(),
            author: [
                'name' => $post->authorName(),
                'username' => $post->authorUsername(),
                'email' => $post->authorEmail(),
                'company' => $post->authorCompany(),
                'website' => $post->authorWebsite()
            ]
        );
    }
    private function __construct(
        public string $title,
        public string $body,
        public array $author,
    )
    {
    }
}
