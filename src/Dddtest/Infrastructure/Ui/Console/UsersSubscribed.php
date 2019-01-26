<?php

namespace Dddtest\Infrastructure\Ui\Console;

use Dddtest\Application\Subscribed\SubscribedQuery;
use Dddtest\Domain\Model\User;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

class UsersSubscribed extends Command
{
    private $messageBus;

    public function __construct(MessageBusInterface $messageBus)
    {
        parent::__construct();
        $this->messageBus = $messageBus;
    }

    protected function configure()
    {
        $this
            ->setName('user:subscribed')
            ->setDescription('Users subscribed to the newsletter')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var User[] $users */
        $users = $this->messageBus
            ->dispatch(
                SubscribedQuery::create()
            )
            ->last(HandledStamp::class)
            ->getResult();

        $output->writeln('<info>Users subscriptions:</info>');
        \array_walk(
            $users,
            static function (User $user) use ($output) {
                $output->writeln(\sprintf('<comment>%s %s</comment>', $user->id(), $user->email()));
            }
        );
        $count = \count($users);
        $output->writeln(\sprintf('<comment>%d user%s subscribed.</comment>', $count, $count !== 1 ? 's' : ''));
    }
}
