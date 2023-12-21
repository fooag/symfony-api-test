<?php 
namespace App\Service\Handler;
use App\Entity\IEntity;

interface IHandler
{
    public function handle(string $id,string $vermittlerId, string $signature);
}