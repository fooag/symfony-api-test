<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Kunden;
use App\Service\KundenService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class KundenController extends AbstractController
{
    public function __construct(
        private readonly KundenService $service,
        private readonly SerializerInterface $serializer
    ) {
    }

    #[Route('foo/kunden', name: 'get_kunden', methods: ['GET'])]
    public function index(): JsonResponse
    {
        $user = $this->getUser();
        if ($user === null) {
            return new JsonResponse('Not authenticated', 401);
        }
       $kunden = $this->service->getKunden($user->getVermittlerId());

        return new JsonResponse(
            data: $this->serializer->serialize($kunden, 'json'),
            json: true
        );
    }
}
