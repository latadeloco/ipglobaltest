<?php

namespace App\Article\Post\Domain;

interface Post
{
    public function title(): string;
    public function body(): string;

    public function authorName(): string;
    public function authorUsername(): string;
    public function authorEmail(): string;
    public function authorAddress(): string;
    public function authorPhone(): string;
    public function authorWebsite(): string;
    public function authorCompany(): string;

    public function link(Author $author): void;
}
