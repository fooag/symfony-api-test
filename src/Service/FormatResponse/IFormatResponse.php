<?php

namespace App\Service\FormatResponse;

use Symfony\Component\HttpFoundation\JsonResponse;

interface IFormatResponse
{
    public function getResponse(mixed $data, int $status = 200, array $headers = [], array $context = []): JsonResponse;
}
