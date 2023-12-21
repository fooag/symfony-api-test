<?php

namespace App\Service\Handler;

use App\Model\FactoryModel;
use App\Model\Kunden;
use Doctrine\ORM\EntityManagerInterface;

class KundenSubHandler implements ISubCollectionHandler
{
    public function __construct(private EntityManagerInterface $entityManager,
                                private FactoryModel $factoryModel)
    {
    }

    /**
     *  Create kunde model instance and call getAdressen function for that model
     *
     * @param string $kundeId
     * @param string $vermittlerId
     * @return array
     */
    public function handle(string $kundeId, string $vermittlerId): array
    {
        $kundeModel = $this->factoryModel->create(Kunden::class);
        $adressen = $kundeModel->getAdressen($kundeId, $vermittlerId);

        return $adressen;
    }

    /**
     * Create kunde model instance and call getAdresseDetails function for that model
     *
     * @param string $kundeId
     * @param string $vermittlerId
     * @return array
     */
    public function kundeAdresseDetailshandle(string $kundeId, string $adresseId, string $vermittlerId): array
    {
        $kundeModel = $this->factoryModel->create(Kunden::class);
        $adressen = $kundeModel->getAdresseDetails($kundeId, $adresseId, $vermittlerId);

        return $adressen;
    }

    /**
     * Create kunde model instance and call getUsers function for that model
     *
     * @param string $kundeId
     * @param string $vermittlerId
     * @return array
     */
    public function userHandle(string $kundeId, string $vermittlerId): array
    {
        $kundeModel = $this->factoryModel->create(Kunden::class);
        $adressen = $kundeModel->getUsers($kundeId, $vermittlerId);

        return $adressen;
    }
}