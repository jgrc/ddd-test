<?php
declare(strict_types=1);

namespace Dddtest\Infrastructure\Ui\Bus;

use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Middleware\MiddlewareInterface;
use Symfony\Component\Messenger\Middleware\StackInterface;

class LoggerMiddleware implements MiddlewareInterface
{
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function handle(Envelope $envelope, StackInterface $stack): Envelope
    {
        $message = $this->messageToAssoc($envelope);
        try {
            $this->logger->debug('Message bus started to dispatch', ['message' => $message]);
            $envelope = $stack->next()->handle($envelope, $stack);
            $this->logger->info('Message bus dispatched', ['message' => $message]);

            return $envelope;
        } catch (\Throwable $throwable) {
            $this->logger->error(
                'Message bus fails when dispatch',
                [
                    'message' => $message,
                    'exception' => $this->throwableToAssoc($throwable)
                ]
            );

            throw $throwable;
        }
    }

    private function messageToAssoc(Envelope $envelope): array
    {
        return [
            'class' => \get_class($envelope->getMessage()),
            'payload' => \json_decode(\json_encode($envelope->getMessage()), true)
        ];
    }

    private function throwableToAssoc(\Throwable $throwable): array
    {
        return [
            'class' => \get_class($throwable),
            'message' => $throwable->getMessage(),
            'code' => $throwable->getCode(),
            'file' => $throwable->getFile(),
            'line' => $throwable->getLine()
        ];
    }
}
