<?php

declare(strict_types=1);

namespace App\Service\UserBundle;

use App\Entity\Std\Agent;
use App\Entity\Std\Customer;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * handle user cruds
 *
 * @author    Julian Engler <info@julian-engler.de>
 * @package   App\Service\UserBundle
 * @version   1.0.0
 * @since     1.0.0
 */
class CustomerCrudService
{
    /**
     * @var \Doctrine\ORM\EntityManagerInterface
     */
    protected EntityManager $entityManager;

    /**
     * @var \App\Service\UserBundle\CustomerMapper
     */
    protected CustomerMapper $customerMapper;

    /**
     * @var \Symfony\Component\Validator\Validator\ValidatorInterface
     */
    protected ValidatorInterface $validator;

    /**
     * @param \Doctrine\ORM\EntityManagerInterface $entityManager
     * @param \App\Service\UserBundle\CustomerMapper $customerMapper
     * @param \Symfony\Component\Validator\Validator\ValidatorInterface $validator
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        CustomerMapper $customerMapper,
        ValidatorInterface $validator
    ) {
        $this->entityManager = $entityManager;
        $this->customerMapper = $customerMapper;
        $this->validator = $validator;
    }

    /**
     * load customers
     *
     * @return Customer[]
     */
    public function getActiveCustomerCollection(): array
    {
        $customer = $this->entityManager->getRepository(Customer::class);
        return $customer->findActiveCustomerCollection();
    }

    public function getActiveCustomerById(int $id): Customer
    {

    }


    public function createCustomer(array $data): Customer
    {
        $agent = $this->getAgentById((string)$data['vermittlerId']);
        if ($agent === null) {
            throw new \Exception('could not find agent');
        }

        $customer = $this->customerMapper->mapCustomerCreateDataToEntity($data, $agent);
        if ($customer === null) {
            throw new \Exception('could not map customer');
        }

        $errorCollection = $this->validator->validate($customer);
        if ($errorCollection->count() > 0) {
            $messageCollection = [];
            /** @var \Symfony\Component\Validator\ConstraintViolation $error */
            foreach ($errorCollection as $error) {
                $messageCollection[] = $error->getMessage();
            }

            throw new \Exception('validation error::' . implode('|', $messageCollection));
        }

        $this->entityManager->persist($customer);
        $this->entityManager->flush();
        return $customer;
    }

    /**
     * load agent by identifier
     *
     * @param string $agentId
     *
     * @return \App\Entity\Std\Agent|null
     */
    protected function getAgentById(string $agentId): ?Agent
    {
        return $this->entityManager->getRepository(Agent::class)
            ->find($agentId);
    }
}
