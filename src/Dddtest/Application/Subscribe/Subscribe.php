<?php
declare(strict_types=1);

namespace Dddtest\Application\Subscribe;

use Dddtest\Domain\Model\User;
use Dddtest\Domain\Model\UserEmail;
use Dddtest\Domain\Model\UserId;
use Dddtest\Domain\Service\Subscribe as ServiceSubscribe;
use Symfony\Component\Messenger\MessageBusInterface;

class Subscribe
{
    private $service;
    private $eventBus;

    public function __construct(ServiceSubscribe $service, MessageBusInterface $eventBus)
    {
        $this->service = $service;
        $this->eventBus = $eventBus;
    }

    public function __invoke(SubscribeCommand $command): void
    {
        $user = User::subscribe(
            UserId::from($command->id()),
            UserEmail::from($command->email())
        );

        ($this->service)($user);
        \array_walk($user->events(), [$this->eventBus, 'dispatch']);
    }
}
