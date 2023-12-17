<?php 
namespace App\Service\Handler;
use App\Entity\IEntity;

interface IGetCollectionHandler
{
    public function handle(int $vermittlerId, string $signature);
}