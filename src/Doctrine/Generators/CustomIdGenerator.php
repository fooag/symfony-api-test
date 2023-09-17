<?php

declare(strict_types=1);

namespace App\Doctrine\Generators;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Id\AbstractIdGenerator;
use Symfony\Component\Uid\Factory\UuidFactory;

final class CustomIdGenerator extends AbstractIdGenerator
{
    public function __construct(
        private readonly UuidFactory $factory
    ) {
    }

    public function generate(EntityManager $em, $entity): string
    {
        return $this->generateId($em, $entity);
    }

    public function generateId(EntityManagerInterface $em, $entity): string
    {
        $uuid = $this->factory->create();

        return strtoupper(substr($uuid->toRfc4122(),0,8));
    }
}