<?php

declare(strict_types=1);

namespace App\Article\Post\Infrastructure\Entrypoint\Api;

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

#[Route(path: '/posts', name: 'api_post_')]
final class PostController extends BaseController implements ControllerInterface
{
    #[Route(
        path: '/all',
        name: 'all_post',
        methods: ['GET']
    )]
    public function allPost(): JsonResponse
    {
        $query = new FindAllArticleQuery();
        $result = $this->manageQuery($query);
        return new JsonResponse($result, Response::HTTP_OK);
    }

    #[Route(
        path: '/view/{postId}',
        name: 'view_by_post_id',
        methods: ['GET']
    )]
    public function viewPostByPostId(int $postId): JsonResponse
    {
        try {
            $query = new FindPostByPostIdQuery($postId);
            $result = $this->manageQuery($query);
            return new JsonResponse($result, Response::HTTP_OK);
        } catch (PostRepositoryException $e) {
            return new JsonResponse($e->getMessage(), Response::HTTP_NOT_FOUND);
        } catch (\Exception $e) {
            return new JsonResponse($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    #[Route(
        path: '/store',
        name: 'store_post',
        methods: ['POST']
    )]
    public function storePost(Request $request): JsonResponse
    {
        try {
            $rawData = json_decode($request->getContent(), true);
            $title = $rawData['title'] ?? '';
            $body = $rawData['body'] ?? '';
            $username = $rawData['username'] ?? '';
            $command = new CreatePostCommand(title: $title, body: $body, username: $username);
            $this->manageCommand($command);
            return new JsonResponse('STORED', Response::HTTP_OK);
        } catch (PostRepositoryException $e) {
            return new JsonResponse($e->getMessage(), Response::HTTP_NOT_FOUND);
        } catch (\Exception $e) {
            return new JsonResponse($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
