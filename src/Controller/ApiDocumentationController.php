<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use ApiPlatform\OpenApi\Factory\OpenApiFactoryInterface;

class ApiDocumentationController
{
    private $openApiFactory;

    public function __construct(OpenApiFactoryInterface $openApiFactory)
    {
        $this->openApiFactory = $openApiFactory;
    }

    #[Route('/foo/docs', name: 'api_docs')]
    public function __invoke(): Response
    {
        $openApi = $this->openApiFactory->__invoke([]);

        return new Response($openApi->toJson(), Response::HTTP_OK, ['Content-Type' => 'application/json']);
    }
}
