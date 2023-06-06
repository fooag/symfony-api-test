<?php
declare(strict_types=1);

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Entity\Broker;
use App\Repository\BrokerRepository;
use App\Repository\CustomerRepository;
use Symfony\Bundle\SecurityBundle\Security;

class CustomersByBrokerProvider extends AbstractSessionProvider
{
    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        return $this->getCustomersByLoggedInBroker();
    }
}
