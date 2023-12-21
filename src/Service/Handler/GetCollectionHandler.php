<?php

namespace App\Service\Handler;

use App\Entity\IEntity;
use App\Exceptions\NotFoundException;
use App\Model\FactoryModel;
use Doctrine\ORM\EntityManagerInterface;

class GetCollectionHandler implements IGetCollectionHandler
{
    public function __construct(
        private FactoryModel $factoryModel
    )
    {
    }

    /**
     *  Create the model and call getCollection function for that model
     *
     * @param int $vermittlerId
     * @param string $signature
     * @return mixed
     */
    public function handle(int $vermittlerId, string $signature)
    {
        $model = $this->factoryModel->create($signature);
        $collection = $model->getCollection($vermittlerId);

        return $collection;
    }
}