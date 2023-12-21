<?php
// api/src/Controller/CreateBookPublication.php
namespace App\Controller\GetCollection;

use App\Entity\Kunde;
use App\Model\Kunden;
use App\Model\User;
use App\Service\Handler\IGetCollectibleInterface;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
class UserGetCollectionController extends GetCollectionController
{
    /**
     * @var string $modelName
     */
    protected string $modelName = User::class;
}
