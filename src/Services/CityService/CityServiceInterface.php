<?php

namespace App\Services\CityService;

use App\Entity\Cities;

interface CityServiceInterface
{
    public function createCity(string $name);

    public function findCity(int $cityId);

    public function renameCity(Cities $city, string $newName);

    public  function deleteCity(Cities $city);
}