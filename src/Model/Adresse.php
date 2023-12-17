<?php
namespace App\Model;


use App\Entity\Adresse as AdresseEntity;
use App\Entity\Bundesland;
use App\Entity\IEntity;
use App\Entity\KundeAdresse;
use App\Entity\Kunden;
use App\Exceptions\BadRequestException;
use App\Exceptions\NotFoundException;
use App\Service\AdresseResolver;
use Doctrine\ORM\EntityManagerInterface;

class Adresse extends AbstractModel implements IModel
{
    protected $entity = AdresseEntity::class;

    /**
     * @param array $data
     * @param int $vermittleId
     * @return AdresseEntity
     */
    public function create(array $data, int $vermittleId): IEntity
    {
        //check if any parameter is missing
        $this->resolve($data);

        $adresse = new AdresseEntity();
        $adresse->setStrasse($data["strasse"]);
        $adresse->setOrt($data["ort"]);
        $adresse->setPlz($data["plz"]);
        $bundesland = $this->entityManager->getRepository(Bundesland::class)->find($data["bundesland"]["kuerzel"]);
        $adresse->setBundesland($bundesland);
        $errors = $this->validator->validate($adresse);
        if(count($errors) > 0) {
            throw  new BadRequestException((string) $errors);
        }
        $this->entityManager->persist($adresse);
        $this->entityManager->flush();

        return $adresse;
    }

    /**
     * @param string $id
     * @param string $vermittlerId
     * @return void
     * @throws NotFoundException
     */
    public function delete(string $id, string $vermittlerId): void
    {
        $kundeadressen = $this->entityManager->getRepository(KundeAdresse::class)->findByIdVermittleId($id, $vermittlerId);

        foreach ($kundeadressen as $kundeadresse) {
            $kundeadresse->setGeloescht(true);
            $this->entityManager->persist($kundeadresse);
            $this->entityManager->flush();
        }
        $this->entityManager->flush();
    }

    /**
     * @param array $data
     * @return void
     */
    public function resolve(array $data)
    {
        $data = $this->resolver
            ->configure('strasse', 'string', false)
            ->configure('plz', 'string', false)
            ->configure('ort', 'string', false)
            ->configure('bundesland', 'array', false)
            ->resolve($data);
    }
}