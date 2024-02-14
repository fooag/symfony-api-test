<?php

declare(strict_types=1);

namespace App\Doctrine;

use Doctrine\ORM\Id\AbstractIdGenerator;
use Doctrine\ORM\EntityManager;
use Ramsey\Uuid\Uuid;

class UuidGenerator extends AbstractIdGenerator
{
    public function generate(EntityManager $em, $entity)
    {
        // Generate a UUID
        $uuid = Uuid::uuid4()->toString();

        return strtoupper(substr($uuid, 0, 8));
    }
}