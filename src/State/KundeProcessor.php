<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Entity\Kunde;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;

class KundeProcessor implements ProcessorInterface
{
    private Security $security;

    private EntityManagerInterface $entityManager;


    public function __construct(
        Security               $security,
        EntityManagerInterface $entityManager
    )
    {
        $this->security = $security;
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
        $vermittlerId = $this->security->getUser()->getVermittler()->getId();

        $data->setVermittlerId($vermittlerId);

        $this->entityManager->persist($data);
        $this->entityManager->flush();

        return $data;
    }
}
