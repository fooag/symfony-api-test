<?php

declare(strict_types=1);

namespace App\Controller;

use App\Model\AddKundeModel;
use App\Service\Exception\KundeNotFoundException;
use App\Service\KundenService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
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
    public function getKunden(): JsonResponse
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

    #[Route('foo/kunden/{id}', name: 'get_kunde', methods: ['GET'])]
    public function getKunde(string $id): JsonResponse
    {
        $user = $this->getUser();
        if ($user === null) {
            return new JsonResponse('Not authenticated', 401);
        }
        try {
            $kunden = $this->service->getKunde($id, $user->getVermittlerId());
        } catch (KundeNotFoundException $exception) {
            return new JsonResponse(
                $exception->getMessage(),
                404
            );
        }

        return new JsonResponse(
            data: $this->serializer->serialize($kunden, 'json'),
            json: true
        );
    }

    #[Route('foo/kunden', name: 'add_kunde', methods: ['POST'])]
    public function addKunde(Request $request): JsonResponse
    {
        $user = $this->getUser();
        if ($user === null) {
          #  return new JsonResponse('Not authenticated', 401);
        }

        $model = $this->serializer->deserialize($request->getContent(), AddKundeModel::class, 'json');
        $kunde = $this->service->addKunde($model, 1000);

        return new JsonResponse(
            data: $this->serializer->serialize($kunde, 'json'),
            json: true
        );
    }
}
