<?php
// api/src/Controller/CreateBookPublication.php
namespace App\Controller\Post;

use App\Entity\Kunde;
use App\Exceptions\BadRequestException;
use App\Exceptions\NotFoundException;
use App\Model\FactoryModel;
use App\Service\FormatResponse\IFormatResponse;
use App\Service\Resolver\EntityResolver;
use App\Service\Handler\IPostHandler;
use App\Service\KundeHandler;
use App\Service\Trait\LoggedUserTrait;
use Nelmio\CorsBundle\Options\ResolverInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[AsController]
class PostController extends AbstractController
{
    use LoggedUserTrait;

    public function __construct(private RequestStack     $requestStack,
                                private IPostHandler     $postHandler,
                                private FactoryModel     $factoryModel,
                                protected EntityResolver $resolver,
                                private IFormatResponse  $format,

    )
    {
    }

    /**
     * Get entity id and entityt type, then call post collection handler to post the entity
     *
     * @param Request $request
     * @param $data
     * @return JsonResponse
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(Request $request, $data): JsonResponse
    {
        try {
            $entityData = json_decode($this->requestStack->getCurrentRequest()->getContent(), true);

            $vermittlerId = $vermittlerId = $this->getVermittlerId();
            $entity = $this->postHandler->handle($entityData, $vermittlerId, $data::class);

            return $this->format->getResponse($entity, status: Response::HTTP_CREATED);

        } catch (NotFoundException $exception) { //NOT FOUND then Return 404 response with error msg

            return $this->format->getResponse($exception->getMessage(), status: Response::HTTP_NOT_FOUND);
        } catch (\Exception | BadRequestException $exception) //Generic Exception, resolve, valition exception
        {

            return $this->format->getResponse($exception->getMessage(), status: Response::HTTP_BAD_REQUEST);
        }
    }
}