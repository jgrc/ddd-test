<?php

use Behat\Behat\Context\Context;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Console\Output\BufferedOutput;

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context
{
    private $container;
    private $application;

    private $output;
    private $exitCode;

    public function __construct()
    {
        $this->container = new ContainerBuilder();
        $loader = new YamlFileLoader($this->container, new FileLocator(__DIR__ . '/../../config'));
        $loader->load('test.yaml');
        $this->application = $this->container->get('console');
    }

    private function application(): Application
    {
        return $this->application;
    }

    /**
     * @AfterScenario
     */
    public function clearFiles()
    {
        $userRepoFile = __DIR__ . '/../../' . $this->container->getParameter('user.repository.file');
        $eventStoreFile = __DIR__ . '/../../' . $this->container->getParameter('event.store.file');

        if (\file_exists($userRepoFile)) {
            \unlink($userRepoFile);
        }
        if (\file_exists($eventStoreFile)) {
            \unlink($eventStoreFile);
        }
    }

    /**
     * @Given a subscribed user with email :email
     */
    public function aSubscribedUserWithEmail(string $email)
    {
        $this->execute("user:subscribe {$email}");
    }

    /**
     * @When I subscribe a user with email :email
     */
    public function iSubscribeAUserWithEmail(string $email)
    {
        $this->execute("user:subscribe {$email}");
    }

    /**
     * @When I want see the subscriptions
     */
    public function iWantSeeTheSubscriptions()
    {
        $this->execute("user:subscribed");
    }

    /**
     * @Then the user should be subscribed
     */
    public function theUserShouldBeSubscribed()
    {
        \Assert\Assert::that($this->exitCode)->same(0, 'Unexpected exit_code');
    }

    /**
     * @Then the subscription fails
     */
    public function theSubscriptionFails()
    {
        \Assert\Assert::that($this->exitCode)->notEq(0, 'Unexpected exit_code');
    }

    /**
     * @Then the email :email appear
     */
    public function theEmailAppear(string $email)
    {
        \Assert\Assert::that($this->exitCode)->same(0, 'Unexpected exit_code');
        \Assert\Assert::that($this->output)->contains($email, 'Email not found in the list');
    }

    private function execute(string $input): void
    {
        $stringInput = new StringInput($input);
        $bufferedOutput = new BufferedOutput();

        try {
            $this->exitCode = $this->application()->doRun($stringInput, $bufferedOutput);
            $this->output = \trim($bufferedOutput->fetch());
        } catch (\Throwable $throwable) {
            $this->exitCode = 1;
        }
    }
}
