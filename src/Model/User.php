<?php
namespace App\Model;

use App\Entity\Adresse;
use App\Entity\IEntity;
use App\Entity\KundeAdresse;
use App\Entity\Kunden as KundenEntity;
use App\Entity\User as UserEntity;
use App\Entity\Vermittler;
use App\Exceptions\BadRequestException;
use App\Exceptions\NotFoundException;
use Doctrine\ORM\EntityManagerInterface;

class User extends AbstractModel implements IModel
{
    protected $entity = UserEntity::class;

    /**
     * @param int $vermittleId
     * @return mixed
     */
    public function getCollection(int $vermittleId): array
    {
        $collection = $this->entityManager->getRepository(UserEntity::class)->findByVermittleId($vermittleId);

        return $collection;
    }


    /**
     * create user
     *
     * @param array $data
     * @param int $vermittleId
     * @return UserEntity
     */
    public function create(array $data, int $vermittleId): IEntity
    {
        $this->resolve($data);
        $user = new UserEntity();
        $user->setPasswd($data['passwd']);
        $user->setEmail($data['email']);
        $user->setAktiv($data['aktiv']);


        $errors = $this->validator->validate($user);
        if(count($errors) > 0) {
            throw  new BadRequestException((string) $errors);
        }

        $hashedPassword = $this->passwordHasher->hashPassword(
            $user,
            $user->getPasswd()
        );
        $user->setPasswd($hashedPassword);

        try {
            $kunde = $this->entityManager->getRepository(KundenEntity::class)
                ->findByIdVermittleId($data['kundenid']['id'], $vermittleId);
        } catch (\Throwable $exception)
        {
            throw new NotFoundException(sprintf('Kunde %s Not Found', $data['kundenid']['id']));
        }



        $user->setKundenid($kunde);


        $this->entityManager->persist($user);

        $this->entityManager->flush();

        return $user;
    }

    /**
     * @param array $data
     * @return void
     */
    public function resolve(array $data)
    {
        $data = $this->resolver
            ->configure('email', 'string', false)
            ->configure('passwd', 'string', false)
            ->configure('aktiv', 'int', false)
            ->configure('kundenid', 'array', false)
            ->resolve($data);
    }
}