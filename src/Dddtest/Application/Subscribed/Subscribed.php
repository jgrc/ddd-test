<?php
declare(strict_types=1);

namespace Dddtest\Application\Subscribed;

use Dddtest\Domain\Model\User;
use Dddtest\Domain\Service\Subscribed as ServiceSubscribed;

class Subscribed
{
    private $service;

    public function __construct(ServiceSubscribed $service)
    {
        $this->service = $service;
    }

    /**
     * @return User[]
     */
    public function __invoke(SubscribedQuery $query): array
    {
        return ($this->service)();
    }
}
