<?php 
namespace App\Service\Handler;

interface IDeleteHandler
{
    public function delete(string $id, string $vermittlerId, string $signature): void;
}