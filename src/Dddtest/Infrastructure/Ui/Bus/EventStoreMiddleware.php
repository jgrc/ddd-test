<?php
declare(strict_types=1);

namespace Dddtest\Infrastructure\Ui\Bus;

use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Middleware\MiddlewareInterface;
use Symfony\Component\Messenger\Middleware\StackInterface;

class EventStoreMiddleware implements MiddlewareInterface
{
    private $file;
    private $data;

    public function __construct(string $file)
    {
        $this->file = $file;
        $this->data = \file_exists($this->file) ? \json_decode(\file_get_contents($this->file), true) : [];
    }

    public function handle(Envelope $envelope, StackInterface $stack): Envelope
    {
        $this->data[] = $envelope->getMessage();
        \file_put_contents($this->file, \json_encode($this->data, \JSON_PRETTY_PRINT));
        return $stack->next()->handle($envelope, $stack);
    }
}
