<?php

namespace App\Article\Post\Domain;

use App\Article\Post\Domain\Exception\AuthorNotFoundException;
use App\Article\Post\Domain\Exception\NotPostsFoundException;
use App\Article\Post\Domain\Exception\PostRepositoryException;

interface PostRepository
{
    /**
     * @throws NotPostsFoundException
     * @throws PostRepositoryException
     * @return Post[]
     */
    public function findAll(): array;

    /**
     * @throws AuthorNotFoundException
     * @throws NotPostsFoundException
     * @throws PostRepositoryException
     */
    public function findPostByPostId(PostId $postId): Post;

    public function store(Post $post): void;
}
