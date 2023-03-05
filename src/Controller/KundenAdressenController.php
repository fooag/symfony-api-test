<?php

namespace App\Controller;

use App\Entity\KundeAdresse;
use App\Entity\TblKunden;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class KundenAdressenController extends AbstractController
{
    /**
     * @Route(
     *     path="/kunden/{id}/adressen",
     *     name="api_kunde_adressen",
     *     methods={"POST"},
     *     defaults={
     *         "_api_resource_class"=TblKunden::class,
     *         "_api_item_operation_name"="get_adressen"
     *     }
     * )
     * @return  array<int, KundeAdresse>
     */
    public function __invoke(TblKunden $data, EntityManagerInterface $entityManager): array
    {
        return $entityManager->getRepository(KundeAdresse::class)->findBy(['kunde_id' => $data->getId()]);
    }
}
