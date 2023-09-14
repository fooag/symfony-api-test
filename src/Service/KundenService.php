<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Kunden;
use App\Repository\KundeAdresseRepository;
use App\Repository\KundenRepository;
use Doctrine\Common\Collections\Collection;

class KundenService
{
    public function __construct(
        private readonly KundenRepository $repository,
        private readonly KundeAdresseRepository $kundeAdresseRepository
    ) {
    }

    public function getKunden(int $vermittlerId): Collection
    {
        $kunden = $this->repository->findByVermittlerId($vermittlerId);
        /** @var Kunden $kunde */
        foreach ($kunden as $kunde) {
            $kundeAdressen = $this->kundeAdresseRepository->findByKundeId($kunde->getId());
            $kunde->setAddressen($kundeAdressen);
        }

        return $kunden;
    }
}
