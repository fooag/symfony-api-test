<?php
declare(strict_types=1);

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Entity\Customer;
use App\Service\BrokerSessionService;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * Api-platform state provider to get list of addresses by logged in Broker, respecting deleted flag.
 */
class AddressesByBrokerProvider implements ProviderInterface
{

    public function __construct(
        private readonly BrokerSessionService $brokerSessionService
    ) {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        /** @var Collection<Customer> $customers */
        $customers = $this->brokerSessionService->getCustomersByLoggedInBroker();

        //todo replace block by one query
        $addresses = new ArrayCollection();
        foreach ($customers as $customer) {
            $addresses->add($customer->getAddresses());
        }

        return $addresses;
    }
}
