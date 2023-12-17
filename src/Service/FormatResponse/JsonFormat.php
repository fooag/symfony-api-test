<?php

namespace App\Service\FormatResponse;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;

class JsonFormat implements IFormatResponse
{
    public function __construct(private SerializerInterface $serializer)
    {
    }

    /**
     * @param mixed $data
     * @param int $status
     * @param array $headers
     * @param array $context
     * @return JsonResponse
     */
    public function getResponse(mixed $data, int $status = 200, array $headers = [], array $context = []): JsonResponse
    {
        $json = $this->serializer->serialize($data, 'json', array_merge([
    //        'json_encode_options' => JsonResponse::DEFAULT_ENCODING_OPTIONS,

        ], $context));

        return new JsonResponse($json, $status, $headers, true);
    }
}
