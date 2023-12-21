<?php

namespace App\Service\Handler;

use App\Exceptions\NotFoundException;
use App\Model\FactoryModel;

class PostHandler implements IPostHandler
{
    public function __construct(private FactoryModel $factoryModel)
    {

    }

    /**
     * Create the model and call create function for that model
     *
     * @param string $id
     * @param string $vermittlerId
     * @param string $signature
     * @return mixed
     * @throws NotFoundException
     */
    public function handle(array $data, string $vermittlerId, string $signature)
    {
        $model = $this->factoryModel->create($signature);
        $entity = $model->create($data, $vermittlerId);

        return $entity;
    }
}