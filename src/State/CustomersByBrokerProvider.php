<?php
declare(strict_types=1);

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Service\BrokerSessionService;

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
