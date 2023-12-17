<?php

namespace App\Controller;

use App\Entity\VermittlerUser;
use App\Service\FormatResponse\IFormatResponse;
use App\Service\Resolver\EntityResolver;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\User;

class AuthenticationController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private IFormatResponse        $format)
    {
    }

    /**
     * @param UserInterface $user
     * @param JWTTokenManagerInterface $JWTManager
     * @return JsonResponse
     */
    public function getTokenUser(Request $request, JWTTokenManagerInterface $JWTManager): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $vermittlerUser = $this->entityManager->getRepository(VermittlerUser::class)->findBy(['email' => $data['email']]);
        if (empty($vermittlerUser))
        {
            return $this->format->getResponse('Not Found', status: Response::HTTP_NOT_FOUND);
        }

        if ($vermittlerUser[0]->getAktiv() === 0)
        {
            return $this->format->getResponse('User Not Aktiv', status: Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $user = new VermittlerUser();
        $user->setEmail($data['email']);
        $user->setPasswd($data['passwd']);

        return $this->format->getResponse(['token' => $JWTManager->create($user)], status: Response::HTTP_OK);
    }
}

