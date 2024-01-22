<?php

declare(strict_types=1);

namespace App\Doctrine;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Id\AbstractIdGenerator;
use Symfony\Component\Uid\Factory\UuidFactory;

class CustomerIdGenerator extends AbstractIdGenerator
{
    public function __construct(
        private readonly UuidFactory $factory
    ) {
    }

    public function generateId(EntityManagerInterface $em, $entity)
    {
        return strtoupper(substr($this->factory->create()->toRfc4122(),0,8));
    }
}
