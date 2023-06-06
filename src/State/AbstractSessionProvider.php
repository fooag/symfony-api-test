<?php
declare(strict_types=1);

namespace App\State;

use ApiPlatform\State\ProviderInterface;
use App\Entity\Broker;
use App\Entity\Customer;
use App\Repository\BrokerRepository;
use Doctrine\Common\Collections\ReadableCollection;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Contracts\Service\Attribute\Required;

/**
 * Reads user from session to get App\Entity\Broker and Collection<Customer> customers by ˛App\Entity\Broker
 */
abstract class AbstractSessionProvider implements ProviderInterface
{
    protected BrokerRepository $brokerRepository;

    #[Required]
    public function setBrokerRepository(BrokerRepository $brokerRepository): void
    {
        $this->brokerRepository = $brokerRepository;
    }

    protected Security $security;

    #[Required]
    public function setSecurity(Security $security): void
    {
        $this->security = $security;
    }

    protected function getCustomersByLoggedInBroker(): ?ReadableCollection
    {
        //todo could be replaced by one query
        $user = $this->getUserFromSession();
        $broker = $this->getBroker($user);

        return $this->getCustomersByBroker($broker)?->filter(function(Customer $customer) {
            return $customer->isDeleted() === false;
        });
    }

    private function getUserFromSession(): ?UserInterface
    {
        return $this->security->getUser();
    }

    private function getBroker($user): Broker
    {
        return $this->brokerRepository->findOneBy(['id' => $user?->getId()]);
    }

    private function getCustomersByBroker(Broker $broker): ?\Doctrine\Common\Collections\Collection
    {
        return $broker->getCustomers();
    }
}