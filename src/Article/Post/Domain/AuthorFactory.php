<?php

namespace App\Article\Post\Domain;

interface AuthorFactory
{
    public function make(array $data): Author;
}
