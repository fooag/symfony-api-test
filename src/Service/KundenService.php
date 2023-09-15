<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Kunde;
use App\Entity\User;
use App\Model\AddKundeModel;
use App\Repository\KundeAdresseRepository;
use App\Repository\KundenRepository;
use App\Repository\VermittlerRepository;
use App\Service\Exception\KundeNotFoundException;
use App\Service\Exception\ServiceNotAvailableException;
use App\Service\Exception\VermittlerNotFoundException;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Exception\ORMException;

class KundenService
{
    public function __construct(
        private readonly KundenRepository $repository,
        private readonly KundeAdresseRepository $kundeAdresseRepository,
        private readonly VermittlerRepository $vermittlerRepository,
        private readonly EntityManagerInterface $entityManager
    ) {
    }

    public function getKunden(int $vermittlerId): Collection
    {
        $kunden = $this->repository->findByVermittlerId($vermittlerId);

        /** @var Kunde $kunde */
        foreach ($kunden as $kunde) {
            $kundeAdressen = $this->kundeAdresseRepository->findByKundeId($kunde->getId());
            $kunde->setAddressen($kundeAdressen);
        }

        return $kunden;
    }

    public function getKunde(string $kundeId, int $vermittlerId): Kunde
    {
        $kunde = $this->repository->findOneBy(['id' => $kundeId, 'vermittler' => $vermittlerId]);
        if ($kunde === null) {
            throw new KundeNotFoundException(
                sprintf('Kunde with id : %s not found', $kundeId)
            );
        }

        $kundeAdressen = $this->kundeAdresseRepository->findByKundeId($kunde->getId());
        $kunde->setAddressen($kundeAdressen);

        return $kunde;
    }

    /**
     * @throws ServiceNotAvailableException
     * @throws VermittlerNotFoundException
     */
    public function addKunde(AddKundeModel $model, int $vermittlerId): Kunde
    {
        $vermittler = $this->vermittlerRepository->find($vermittlerId);
        if ($vermittler === null) {
            throw new VermittlerNotFoundException('Vermittler not found');
        }

        $user = new User($model->getUsername(),$model->getPassword());
        $kunde = new Kunde(
            $model->getNachname(),
            $model->getVorname(),
            '',
            $model->getGeburtsdatum(),
            '',
            $model->getUsername(),
            $vermittler,
            $user
        );
        $user->setKunde($kunde);

        try {
            $this->entityManager->persist($kunde);
            $this->entityManager->flush();
        } catch (\InvalidArgumentException|ORMException $exception) {
            throw new ServiceNotAvailableException('Could not save Kunde');
        }

        return $kunde;
    }
}
