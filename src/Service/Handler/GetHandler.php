<?php

namespace App\Service\Handler;
use App\Entity\IEntity;
use App\Exceptions\NotFoundException;
use App\Model\FactoryModel;
use Doctrine\ORM\EntityManagerInterface;

class GetHandler implements IHandler
{
    public function __construct(private FactoryModel $factoryModel)
    {

    }

    /**
     *  Create the model and call get function for that model
     *
     * @param string $id
     * @param string $vermittlerId
     * @param string $signature
     * @return mixed
     * @throws NotFoundException
     */
    public function handle(string $id, string $vermittlerId, string $signature)
    {
        $model = $this->factoryModel->create($signature);
        $entity = $model->get($id, $vermittlerId);
        if (empty($entity))
        {
            throw new NotFoundException('Not Found!');
        }

        return $entity;
    }
}

