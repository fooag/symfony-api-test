<?php

namespace App\Service\Handler;

interface IPostHandler
{
    public function handle(array $id,string $vermittlerId, string $signature);
}