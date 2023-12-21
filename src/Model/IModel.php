<?php
namespace App\Model;
use App\Entity\IEntity;

interface IModel
{
    public function get(string $id, int $vermittleId);
    public function getCollection(int $vermittleId): array;
    public function delete(string $id, string $vermittlerId): void;
    public function create(array $data, int $vermittleId): IEntity;

    public function resolve(array $data);
}