<?php

namespace App\Service\Generator;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Id\AbstractIdGenerator;

class IdGenerator extends AbstractIdGenerator
{
    /**
     * {@inheritdoc}
     */
    public function generate(EntityManagerInterface $em, $entity)
    {
        $id =  strtoupper(substr(uniqid(), 0, 8));

        if (null !== $em->getRepository(get_class($entity))->findOneBy(['id' => $id])) {
            $id = $this->generate($em, $entity);
        }

        return $id;
    }

}