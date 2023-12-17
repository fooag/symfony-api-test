<?php

namespace App\Service\Handler;
use App\Exceptions\NotFoundException;
use App\Model\FactoryModel;
use Doctrine\ORM\EntityManagerInterface;

class DeleteHandler implements IDeleteHandler
{
    public function __construct(private EntityManagerInterface $entityManager, private FactoryModel $factoryModel)
    {
    }

    /**
     * Create the model and call delete function for that model
     *
     * @param string $id
     * @param string $vermittlerId
     * @param string $signature
     * @return void
     */
    public function delete(string $id, string $vermittlerId, string $signature): void
    {
        $model = $this->factoryModel->create($signature);
        $model->delete($id, $vermittlerId);
    }
}

