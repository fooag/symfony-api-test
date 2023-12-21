<?php 
namespace App\Service\Handler;
use App\Entity\IEntity;

interface ISubCollectionHandler
{
    public function handle(string $kundeId, string $vermittlerId);
}