<?php

namespace Dddtest\Infrastructure\Ui\Console;

use Dddtest\Application\Subscribe\SubscribeCommand;
use Dddtest\Domain\Model\User;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class UserSubscribe extends Command
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
            ->setName('user:subscribe')
            ->setDescription('Subscribe user to the newsletter')
            ->addArgument('email', InputArgument::REQUIRED, 'User email to subscribe')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var User $user */
        $this->messageBus->dispatch(
            SubscribeCommand::from(
                $id = Uuid::uuid4()->toString(),
                $email = $input->getArgument('email')
            )
        );
        $output->writeln(\sprintf('<info>User with id %s and email %s subscribed</info>', $id, $email));
    }
}
