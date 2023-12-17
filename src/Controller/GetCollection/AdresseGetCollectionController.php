<?php
// api/src/Controller/CreateBookPublication.php
namespace App\Controller\GetCollection;

use App\Entity\Kunde;
use App\Model\Adresse;
use App\Service\Handler\IGetCollectibleInterface;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
class AdresseGetCollectionController extends GetCollectionController
{
    /** @var string $modelName */
    protected string $modelName = Adresse::class;
}
