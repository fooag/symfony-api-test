<?php

declare(strict_types=1);

namespace App\Doctrine\Generator;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Id\AbstractIdGenerator;
use Symfony\Component\Uid\Factory\UuidFactory;

final class UidGenerator extends AbstractIdGenerator
{
    public function __construct(
        private readonly UuidFactory $factory
    ) {
    }

    public function generate(EntityManager $em, $entity): string
    {
        $uuid = $this->factory->create();

        return strtoupper(substr($uuid->toRfc4122(),0,8));
    }
}
