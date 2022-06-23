<?php

namespace App\Services\CityService;

use App\Entity\Cities;

class CityService implements CityServiceInterface
{
    private $em;

    public function __construct(\Doctrine\ORM\EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }

    public function createCity(string $name)
    {
        $city = new \App\Entity\Cities();
        $city->setName($name);

        $this->em->persist($city);
        $this->em->flush();
    }

    public function findCity(int $cityId)
    {
        return $this
            ->em
            ->getRepository(Cities::class)
            ->find($cityId);
    }

    public function renameCity(Cities $city, string $newName)
    {
        $city->setName($newName);
        $this->em->flush();
    }

    public function deleteCity(Cities $city)
    {
        $this->em->remove($city);
        $this->em->flush();
    }
}