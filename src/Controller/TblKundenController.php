<?php


namespace App\Controller;

use App\Entity\Adresse;
use App\Entity\Bundesland;
use App\Entity\KundeAdresse;
use App\Entity\TblKunden;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class TblKundenController extends AbstractController
{
    public function __invoke(TblKunden $data)
    {
        // Noch nicht fertig!!!
        $adresse = ($this->getDoctrine()->getRepository(TblKunden::class))->findKundeAdresse($data->getId());
        $result = [
            'kunde' => $data,
            'adresse' => $adresse
        ];
        return $result;
    }

}