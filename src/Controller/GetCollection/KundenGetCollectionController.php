<?php
// api/src/Controller/CreateBookPublication.php
namespace App\Controller\GetCollection;

use App\Entity\Kunde;
use App\Model\Kunden;
use App\Service\Handler\IGetCollectibleInterface;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
class KundenGetCollectionController extends GetCollectionController
{
    protected string $modelName = Kunden::class;
}
