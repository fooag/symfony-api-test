<?php
// api/src/Controller/CreateBookPublication.php
namespace App\Controller\Delete;

use App\Entity\Kunde;
use App\Exceptions\NotFoundException;
use App\Service\FormatResponse\IFormatResponse;
use App\Service\Handler\IDeleteHandler;
use App\Service\Trait\LoggedUserTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
class DeleteController extends AbstractController
{
    use LoggedUserTrait;

    protected string $modelName = '';

    public function __construct(private RequestStack    $requestStack,
                                private IDeleteHandler  $deleteHandler,
                                private IFormatResponse $format,
    )
    {
    }

    /**
     * Get entity id and entityt type, then call delete handler to delete the entity
     *
     * @param Request $request
     * @param $data
     * @param string $id
     * @return JsonResponse
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(Request $request, $data, string $id): JsonResponse
    {
        try {
            $vermittlerId = $this->getVermittlerId();
            $this->deleteHandler->delete((string)$id, $vermittlerId, $data::class);

            return $this->format->getResponse([], status: Response::HTTP_CREATED);
        } catch (NotFoundException $e) { //NOT FOUND then Return 404 response with error msg

            return $this->format->getResponse($e->getMessage(), status: Response::HTTP_NOT_FOUND);
        }
    }
}