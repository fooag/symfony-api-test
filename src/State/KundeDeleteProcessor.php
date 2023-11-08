<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Entity\Kunde;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;

class KundeDeleteProcessor implements ProcessorInterface
{
    private EntityManagerInterface $entityManager;


    public function __construct(
        EntityManagerInterface $entityManager
    )
    {
        $this->entityManager = $entityManager;
    }


    /**
     * @param Kunde     $data
     * @param Operation $operation
     * @param array     $uriVariables
     * @param array     $context
     *
     * @return Kunde|null
     */
    public function process($data, Operation $operation, array $uriVariables = [], array $context = []) : ?Kunde
    {
        $data->setGeloescht(1);

        $this->entityManager->persist($data);
        $this->entityManager->flush();

        return $data;
    }
}
