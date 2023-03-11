<?php

declare(strict_types=1);

namespace App\Article\Post\Infrastructure\Delivery\Web;

use App\Article\Post\Application\Command\CreatePostCommand;
use App\Article\Post\Application\Query\FindAllArticleQuery;
use App\Article\Post\Application\Query\FindPostByPostIdQuery;
use App\Article\Post\Domain\Exception\PostRepositoryException;
use App\Shared\Symfony\Controller\ControllerInterface;
use App\Shared\Symfony\Dependencies\BaseController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: '/', name: 'web_post_')]
final class PostController extends BaseController implements ControllerInterface
{
    #[Route(
        name: 'posts_view',
        methods: ['GET']
    )]
    public function posts(): Response
    {
        return $this->render(view: 'posts.html.twig');
    }

    #[Route(
        path: 'post/{postId}',
        name: 'posts_view_by_post_id',
        methods: ['GET']
    )]
    public function viewIndividualPost(int $postId): Response
    {
        return $this->render(
            view: 'post.html.twig',
            parameters: [
                'postId' => $postId
            ]);
    }

    #[Route(
        path: 'create-post',
        name: 'create_post',
        methods: ['GET']
    )]
    public function createPost(): Response
    {
        return $this->render(view: 'create-post.html.twig');
    }
}
