<?php

namespace App\Model;

use App\Exceptions\NotFoundException;
use App\Service\Resolver\EntityResolver;
use Doctrine\ORM\EntityManagerInterface;
use Nelmio\CorsBundle\Options\ResolverInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class FactoryModel
{
    public function __construct(private EntityManagerInterface      $entityManager,
                                private UserPasswordHasherInterface $passwordHasher,
                                protected ValidatorInterface $validator,
                                protected EntityResolver $resolver,
    )
    {

    }

    /**
     * Create a model instance using signature (Class Name)
     *
     * @param string $signature
     * @return IModel
     * @throws NotFoundException
     * @throws \ReflectionException
     */
    public function create(string $signature): IModel
    {
        // Get the class inforamtion
        $reflect = new \ReflectionClass($signature);

        // get classname and build the correct one with namespace
        $modelName = __NAMESPACE__ . '\\' . $reflect->getShortName();
        if (!class_exists($modelName)){

            throw new NotFoundException(sprintf(' Class %s Not Found!', $signature));
         }

        $model = new $modelName($this->entityManager, $this->passwordHasher, $this->validator, $this->resolver);

        return $model;
    }
}