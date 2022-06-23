<?php

namespace App\Services\StreetService;

use App\Entity\Streets;

interface StreetServiceInterface
{
    public function createStreet(string $name);

    public function findStreet(int $streetId);

    public function renameStreet(Streets $street, string $newName);

    public  function deleteStreet(Streets $street);
}