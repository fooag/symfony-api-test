<?php
declare(strict_types=1);

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Service\BrokerSessionService;

/**
 * Api-platform state provider to return list of Customer(s) related to logged in Broker.
 */
class CustomersByBrokerProvider implements ProviderInterface
{
    public function __construct(
        private readonly BrokerSessionService $brokerSessionService
    ) {
    }
    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        return $this->brokerSessionService->getCustomersByLoggedInBroker();
    }
}
