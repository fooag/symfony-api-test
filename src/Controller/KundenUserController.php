<?php

namespace App\Controller;

use App\Entity\TblKunden;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class KundenUserController extends AbstractController
{
    /**
     * @Route(
     *     path="/kunden/{id}/user",
     *     name="api_kunden_user",
     *     methods={"POST"},
     *     defaults={
     *         "_api_resource_class"=TblKunden::class,
     *         "_api_item_operation_name"="get_user"
     *     }
     * )
     * @return  array<int, User>
     */
    public function __invoke(TblKunden $data, EntityManagerInterface $entityManager): array
    {
        return $entityManager->getRepository(User::class)->findBy(['kundenid' => $data->getId()]);
    }
}
