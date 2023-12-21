<?php
namespace App\Model;

use App\Entity\Adresse;
use App\Entity\IEntity;
use App\Entity\KundeAdresse;
use App\Entity\Kunden as KundenEntity;
use App\Entity\Vermittler;
use App\Exceptions\BadRequestException;
use App\Exceptions\NotFoundException;

class Kunden extends AbstractModel implements IModel
{
    protected $entity = KundenEntity::class;
    /**
     * @param int $vermittleId
     * @return mixed
     */
    public function getCollection(int $vermittleId): array
    {
        $collection = $this->entityManager->getRepository(KundenEntity::class)->findByVermittleId($vermittleId);

        return $collection;
    }

    /**
     * create kunde
     *
     * @param array $data
     * @param int $vermittleId
     * @return KundenEntity
     * @throws NotFoundException
     */
    public function create(array $data, int $vermittleId): IEntity
    {
        $this->resolve($data);
        $vermitler = $this->entityManager->getRepository(Vermittler::class)->find($vermittleId);

        $kunde = new KundenEntity();

        $kunde->setVorname($data['vorname']);
        $kunde->setName($data['name']);
        $kunde->setEmail($data['email']);
        $kunde->setGeburtsdatum(new \DateTime($data['geburtsdatum']));
        $kunde->setGeloescht(0);
        $kunde->setVermittler($vermitler);
        $errors = $this->validator->validate($kunde);
        if(count($errors) > 0) {
            throw  new BadRequestException((string) $errors);
        }

        $this->entityManager->persist($kunde);
        $this->addAdresses($data['kundeAdresses'], $kunde);

        $this->entityManager->flush();

        return $kunde;
    }

    /**
     * add addresses to kunde
     *
     * @param array $adresses
     * @param KundenEntity $kunden
     * @return void
     * @throws NotFoundException
     */
    protected function addAdresses(array $adresses, KundenEntity $kunden)
    {
        foreach ($adresses as $adress)
        {
            $adresse = $this->entityManager->getRepository(Adresse::class)->find($adress['adresse'][0]);
            if (is_null($adresse))
            {
                throw new NotFoundException('Not Found');
            }

            $kundeAdresse = new KundeAdresse();
            $kundeAdresse->setAdresse($adresse);
            $kundeAdresse->setGeschaeftlich($adress['geschaeftlich']);
            $kundeAdresse->setRechnungsadresse($adress['rechnungsadresse']);
            $kundeAdresse->setGeloescht(false);
            $kundeAdresse->setKunde($kunden);

            $errors = $this->validator->validate($kundeAdresse);
            if(count($errors) > 0) {
                throw  new BadRequestException((string) $errors);
            }

            $this->entityManager->persist($kundeAdresse);
        }
    }

    /**
     * return array of kunden address
     * @param string $kundeId
     * @param string $vermittlerId
     * @return array
     */
    public function getAdressen(string $kundeId, string $vermittlerId): array
    {
        $collection = $this
            ->entityManager
            ->getRepository(Adresse::class)
            ->findByKundeIdVermittleId($kundeId, $vermittlerId);

        return $collection;
    }

    /**
     * return array of kunden address
     * @param string $kundeId
     * @param string $vermittlerId
     * @return array
     */
    public function getAdresseDetails(string $kundeId, string $adresseId, string $vermittlerId): array
    {
        $collection = $this
            ->entityManager
            ->getRepository(Adresse::class)
            ->findDetailsByKundeIdVermittleId($kundeId, $adresseId, $vermittlerId);

        return $collection;
    }

    /**
     * @param string $kundeId
     * @param string $vermittlerId
     * @return array
     */
    public function getUsers(string $kundeId, string $vermittlerId): array
    {
        // Use getUsers function in Kunde to retrieve the Data
        /** @var KundenEntity $kunde */
        $kunde = $this
            ->entityManager
            ->getRepository(KundenEntity::class)
            ->findByIdVermittleId($kundeId, $vermittlerId);

        return $kunde->getUsers()->toArray();
    }

    /**
     * @param array $data
     * @return void
     */
    public function resolve(array $data)
    {
        $data = $this->resolver
            ->configure('name', 'string', false)
            ->configure('email', 'string', false)
            ->configure('vorname', 'string', false)
            ->configure('firma', 'string', false)
            ->configure('geburtsdatum', 'string', false)
            ->configure('geschlecht', 'string', false)
            ->configure('ort', 'string', false)
            ->configure('kundeAdresses', 'array', false)
            ->resolve($data);
    }
}