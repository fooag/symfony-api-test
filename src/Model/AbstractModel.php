<?php

namespace App\Model;

use App\Entity\Adresse as AdresseEntity;
use App\Entity\IEntity;
use App\Entity\Kunden as KundenEntity;
use App\Exceptions\NotFoundException;
use App\Service\Resolver\EntityResolver;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Nelmio\CorsBundle\Options\ResolverInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class AbstractModel
{
    const GELOESCHT = 1;

    /**
     * @var IEntity
     */
    protected $entity;

    public function __construct(protected EntityManagerInterface      $entityManager,
                                protected UserPasswordHasherInterface $passwordHasher,
                                protected ValidatorInterface $validator,
                                protected EntityResolver $resolver,
    )
    {

    }

    /**
     * get a single Entity
     *
     * @param int $id
     * @param int $vermittleId
     * @return mixed
     */
    public function get(string $id, int $vermittleId): IEntity
    {
        try {
            $entity = $this->entityManager->getRepository($this->entity)->findByIdVermittleId($id, $vermittleId);

        } catch (\Throwable $exception)
        {
            throw new NotFoundException('Not Found!');
        }

        if (is_null($entity)) {
            throw new NotFoundException('Not Found!');
        }

        return $entity;
    }

    /**
     * @param int $vermittleId
     * @return mixed
     */
    public function getCollection(int $vermittleId): array
    {
        $collection = $this->entityManager->getRepository($this->entity)->findByVermittleId($vermittleId);

        return $collection;
    }

    /**
     * delete a single Entity
     *
     * @param string $id
     * @param string $vermittlerId
     * @return void
     * @throws NotFoundException
     */
    public function delete(string $id, string $vermittlerId): void
    {
        $entity = $this->get($id, $vermittlerId);
        if (is_null($entity))
        {
            throw new NotFoundException('Not Found!');
        }

        $entity->setGeloescht(self::GELOESCHT);
        $this->entityManager->persist($entity);
        $this->entityManager->flush();
    }
}