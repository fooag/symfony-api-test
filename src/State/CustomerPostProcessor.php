<?php
declare(strict_types=1);

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Entity\Customer;
use App\Service\BrokerSessionService;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Api-platform state processor to enrich customer by logged in broker using BrokerSessionService to prepare object for
 * POST request.
 */
class CustomerPostProcessor implements ProcessorInterface
{
    public function __construct(
        private readonly BrokerSessionService $brokerSessionService,
        private readonly EntityManagerInterface $entityManager
    ) {
    }

    /**
     * @param Customer $data
     */
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): null
    {
        if (!($data instanceof Customer)) {
            return null;
        }

        $broker = $this->brokerSessionService->getBrokerByLogin();
        $data->setBroker($broker);

        $this->entityManager->persist($data);
        $this->entityManager->flush();
    }
}