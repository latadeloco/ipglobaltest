<?php

declare(strict_types=1);

namespace App\Article\Post\Application\Query;

use App\Article\Post\Domain\Exception\NotPostsFoundException;
use App\Shared\Domain\QueryHandlerInterface;

final class FindAllArticleQueryHandler implements QueryHandlerInterface
{
    public function __invoke(FindAllArticleQuery $query)
    {
        throw new NotPostsFoundException();
    }
}
