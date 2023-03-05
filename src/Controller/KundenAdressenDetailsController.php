<?php

namespace App\Controller;

use App\Entity\KundeAdresse;
use App\Entity\TblKunden;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class KundenAdressenDetailsController extends AbstractController
{
    /**
     * @Route(
     *     path="/kunden/{id}/adressen/{adress_id}/details",
     *     name="api_kunden_adressen_details",
     *     methods={"POST"},
     *     defaults={
     *         "_api_resource_class"=TblKunden::class,
     *         "_api_item_operation_name"="get_adressen_details"
     *     }
     * )
     * @return  array<int, KundeAdresse>
     */
    public function __invoke(TblKunden $data, EntityManagerInterface $entityManager, Request $request): array
    {
        $adresseId = $request->get('adress_id', null);
        $kundeId = $request->get('id', null);

        if (($adresseId === null || $kundeId === null) || ($kundeId !== null && $data->getId() !== $kundeId)) {
            return [];
        }

        return $entityManager->getRepository(KundeAdresse::class)->findBy([
            'kunde_id' => $data->getId(),
            'adresse_id' => $adresseId
        ]);
    }
}
