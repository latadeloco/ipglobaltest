<?php

declare(strict_types=1);

namespace App\Shared\Symfony\Dependencies;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

class BaseController extends AbstractController
{
    public function __construct(
        private readonly MessageBusInterface $queryBus,
        private readonly MessageBusInterface $commandBus
    )
    {
    }

    protected function manageQuery($query)
    {
        try {
            $envelope = $this->queryBus->dispatch($query);
        } catch (HandlerFailedException $e) {
            $this->processBusException($e);
        }
        return $this->processEnvelope($envelope);
    }

    protected function manageCommand($query)
    {
        try {
            $envelope = $this->commandBus->dispatch($query);
        } catch (HandlerFailedException $e) {
            $this->processBusException($e);
        }
        return $this->processEnvelope($envelope);
    }

    private function processEnvelope($envelope): array
    {
        $handledStamps = $envelope->last(HandledStamp::class);
        $data = $handledStamps->getResult();
        return (array)($data);
    }

    private function processBusException(HandlerFailedException $e)
    {
        while ($e instanceof HandlerFailedException) {
            /** @var \Throwable $e */
            $e = $e->getPrevious();
        }

        throw $e;
    }
}
