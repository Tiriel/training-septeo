<?php

namespace App\Middleware;

use App\Stamp\LoggedStamp;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Middleware\MiddlewareInterface;
use Symfony\Component\Messenger\Middleware\StackInterface;

final class LoggingMiddleware implements MiddlewareInterface
{
    public function __construct(
        private readonly LoggerInterface $logger,
    ) {}

    public function handle(Envelope $envelope, StackInterface $stack): Envelope
    {
        if (!$envelope->last(LoggedStamp::class) instanceof LoggedStamp) {
            $this->logger->info(sprintf('New message : %s', serialize($envelope->getMessage())));
            $envelope = $envelope->with(new LoggedStamp());
        }

        return $stack->next()->handle($envelope, $stack);
    }
}
