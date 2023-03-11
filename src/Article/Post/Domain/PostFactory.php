<?php

namespace App\Article\Post\Domain;

use App\Article\Post\Domain\Exception\InvalidDataException;

interface PostFactory
{
    /**
     * @throws InvalidDataException
     */
    public function make(array $data): Post;
}
