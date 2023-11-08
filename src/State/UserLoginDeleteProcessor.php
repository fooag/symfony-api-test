<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Entity\Security\UserLogin;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserLoginDeleteProcessor implements ProcessorInterface
{
    private EntityManagerInterface $entityManager;

    private UserPasswordHasherInterface $userPasswordHasher;

    public function __construct(
        UserPasswordHasherInterface $passwordHasher,
        EntityManagerInterface $entityManager
    )
    {
        $this->userPasswordHasher = $passwordHasher;
        $this->entityManager = $entityManager;
    }


    /**
     * @param UserLogin     $data
     * @param Operation $operation
     * @param array     $uriVariables
     * @param array     $context
     *
     * @return UserLogin|null
     */
    public function process($data, Operation $operation, array $uriVariables = [], array $context = []) : ?UserLogin
    {
        $data->setAktiv(0);
        $this->entityManager->persist($data);
        $this->entityManager->flush();

        return $data;
    }
}
