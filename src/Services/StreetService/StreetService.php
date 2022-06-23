<?php

namespace App\Services\StreetService;

use App\Entity\Streets;

class StreetService implements StreetServiceInterface
{
    private $em;

    public function __construct(\Doctrine\ORM\EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }

    public function createStreet(string $name)
    {
        $street = new \App\Entity\Streets();
        $street->setName($name);

        $this->em->persist($street);
        $this->em->flush();
    }

    public function findStreet(int $streetId)
    {
        return $this
            ->em
            ->getRepository(Streets::class)
            ->find($streetId);
    }

    public function renameStreet(Streets $street, string $newName)
    {
        $street->setName($newName);
        $this->em->flush();
    }

    public function deleteStreet(Streets $street)
    {
        $this->em->remove($street);
        $this->em->flush();
    }
}