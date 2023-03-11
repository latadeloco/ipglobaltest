<?php

namespace App\Article\Post\Domain;

interface Author
{
    public function name(): string;
    public function username(): string;
    public function email(): string;
    public function address(): string;
    public function phone(): string;
    public function website(): string;
    public function company(): string;
    public function street(): string;
    public function city(): string;
    public function zipcode(): string;
}
