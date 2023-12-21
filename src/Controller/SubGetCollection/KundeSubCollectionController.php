<?php

namespace App\Controller\SubGetCollection;

use App\Exceptions\NotFoundException;
use App\Model\FactoryModel;
use App\Service\FormatResponse\IFormatResponse;
use App\Service\Handler\IGetCollectionHandler;
use App\Service\Handler\ISubCollectionHandler;
use App\Service\Trait\LoggedUserTrait;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;

class KundeSubCollectionController extends AbstractController
{
    use LoggedUserTrait;

    public function __construct(private RequestStack $requestStack,
                                private ISubCollectionHandler $subCollectionHandler,
                                private FactoryModel $factoryModel,
                                private EntityManagerInterface $entityManager,
                                private IFormatResponse $format,

    ) {}

    /**
     * return array of kunden adresse in json format
     *
     * @param string $id
     * @return JsonResponse
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function getAdressen(string $id): JsonResponse
    {
        try {
            $vermittlerId = $vermittlerId = $this->getVermittlerId();
            $collection =  $this->subCollectionHandler->handle($id, $vermittlerId);

            return $this->format->getResponse($collection, status: Response::HTTP_OK, context: ['groups' =>['sub.adresse.read']]);

        } catch(NotFoundException $e) {
            return new JsonResponse($e->getMessage(), Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * return array of kunden adresse in json format
     *
     * @param string $id
     * @return JsonResponse
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function getAdresseDetails(string $id, string $adresseId): JsonResponse
    {
        try {
            $vermittlerId = $vermittlerId = $this->getVermittlerId();
            $collection =  $this->subCollectionHandler->kundeAdresseDetailshandle($id, $adresseId, $vermittlerId);

            return $this->format->getResponse($collection, status: Response::HTTP_OK, context: ['groups' =>['sub.adresse.read']]);

        } catch(NotFoundException $e) {
            return new JsonResponse($e->getMessage(), Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * return array of kunden users in json format
     *
     * @param string $id
     * @return JsonResponse
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function getUsers(string $id): JsonResponse
    {
        try {
            $vermittlerId = $vermittlerId = $this->getVermittlerId();
            $collection =  $this->subCollectionHandler->userHandle($id, $vermittlerId);

            return $this->format->getResponse($collection, status: Response::HTTP_OK);

        } catch(NotFoundException $e) { //NOT FOUND then Return 404 response with error msg

            return $this->format->getResponse($e->getMessage(), status: Response::HTTP_NOT_FOUND);
        }
    }
}