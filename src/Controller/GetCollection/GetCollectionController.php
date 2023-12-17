<?php

namespace App\Controller\GetCollection;

use App\Exceptions\NotFoundException;
use App\Model\FactoryModel;
use App\Service\FormatResponse\IFormatResponse;
use App\Service\Handler\IGetCollectionHandler;
use App\Service\Trait\LoggedUserTrait;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;

class GetCollectionController extends AbstractController
{
    use LoggedUserTrait;

    /**
     * define the mode type
     *
     * @var string $modelName
     */
    protected string $modelName = '';

    public function __construct(private RequestStack $requestStack,
                                private IGetCollectionHandler $getCollectionhandler,
                                private FactoryModel $factoryModel,
                                private EntityManagerInterface $entityManager,
                                private IFormatResponse $format,

    ) {}

    /**
     * Get entity id and entityt type, then call get collection handler to get entity collection
     *
     * @param Request $request
     * @return JsonResponse
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(Request $request): JsonResponse
    {
        try {
            $vermittlerId = $vermittlerId = $this->getVermittlerId();
            $collection =  $this->getCollectionhandler->handle($vermittlerId, $this->modelName);

            return $this->format->getResponse($collection, status: Response::HTTP_OK);

        } catch(NotFoundException $e) {  //NOT FOUND then Return 404 response with error msg
            return $this->format->getResponse($e->getMessage(), status: Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * @param string $modelName
     * @return void
     */
    public function setModel(string $modelName)
    {
        $this->modelName = $modelName;
    }
}