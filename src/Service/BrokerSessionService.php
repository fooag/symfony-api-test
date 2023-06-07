<?php
declare(strict_types=1);

namespace App\Service;

use App\Entity\Broker;
use App\Entity\Customer;
use App\Repository\BrokerRepository;
use Doctrine\Common\Collections\ReadableCollection;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Security\Core\User\UserInterface;

class BrokerSessionService
{

    public function __construct(
        protected BrokerRepository $brokerRepository,
        protected Security $security
    ) {
    }

    public function getCustomersByLoggedInBroker(): ?ReadableCollection
    {
        $broker = $this->getBrokerByLogin();

        return $this->getCustomersByBroker($broker)?->filter(function(Customer $customer) {
            return $customer->isDeleted() === false;
        });
    }

    public function getBrokerByLogin(): Broker
    {
        $user = $this->getUserFromSession();
        return $this->getBrokerFromRepository($user);
    }

    private function getCustomersByBroker(Broker $broker): ?\Doctrine\Common\Collections\Collection
    {
        return $broker->getCustomers();
    }

    private function getUserFromSession(): ?UserInterface
    {
        return $this->security->getUser();
    }

    private function getBrokerFromRepository($user): Broker
    {
        return $this->brokerRepository->findOneBy(['id' => $user?->getId()]);
    }
}