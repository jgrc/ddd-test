<?php
declare(strict_types=1);

namespace Dddtest\Application\Subscribe;

use Dddtest\Domain\Model\UserSubscribed;
use Dddtest\Domain\Util\DomainEvent;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;

class SubscribeTest extends TestCase
{
    private $service;
    private $bus;

    public function setUp()
    {
        $this->service = $this->createMock(\Dddtest\Domain\Service\Subscribe::class);
        $this->bus = $this->createMock(MessageBusInterface::class);
    }

    /**
     * @test
     */
    public function givenSubscribeCommandWhenSubscribeThenDispatchEvent(): void
    {
        $event = $this->createMock(DomainEvent::class);

        $this->service
            ->expects($this->once())
            ->method('__invoke')
            ->willReturn(null);

        $this->bus
            ->expects($this->once())
            ->method('dispatch')
            ->with($this->isInstanceOf(UserSubscribed::class))
            ->willReturn(new Envelope($event));

        (new Subscribe($this->service, $this->bus))(
            SubscribeCommand::from('0d0450bb-41cb-4a67-845d-5117d3c7cfee', 'available@example.com')
        );
    }
}
