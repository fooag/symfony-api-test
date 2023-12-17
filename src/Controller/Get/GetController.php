<?php
// api/src/Controller/CreateBookPublication.php
namespace App\Controller\Get;

use App\Entity\Agent;
use App\Entity\Kunde;
use App\Exceptions\NotFoundException;
use App\Service\FormatResponse\IFormatResponse;
use App\Service\Handler\IHandler;
use App\Service\Trait\LoggedUserTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
class GetController extends AbstractController
{
    use LoggedUserTrait;

    protected string $modelName = '';

    public function __construct(private RequestStack    $requestStack,
                                private IHandler        $handler,
                                private IFormatResponse $format,
    )
    {
    }

    /**
     * get the vermittlerid and call handle function
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
            $vermittlerId = $vermittlerId = $this->getVermittlerId();
            $collection = $this->handler->handle($id, $vermittlerId, $data::class);

            return $this->format->getResponse($collection, status: Response::HTTP_OK);
        } catch (NotFoundException $e) {  //NOT FOUND then Return 404 response with error msg

            return $this->format->getResponse($e->getMessage(), status: Response::HTTP_NOT_FOUND);
        }
    }
}