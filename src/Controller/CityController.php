<?php

namespace App\Controller;

use App\Entity\Cities;
use App\Entity\Users;
use App\Entity\UsersAddresses;
use App\Services\CityService\CityServiceInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CityController extends AbstractController
{
    private $request;

    private $cityService;

    private $em;

    public function __construct(RequestStack $requestStack, CityServiceInterface $cityService, EntityManagerInterface $entityManager)
    {

        $this->request = $requestStack->getCurrentRequest();
        $this->cityService = $cityService;
        $this->em = $entityManager;

    }

    public function addCity()
    {
        $newCity = $this->request->get("new_name");
        if (!$newCity) {
            return $this->json([
                'message' => 'Введите новый город'
            ]);
        }
        $this->cityService->createCity($newCity);
        return $this->json([
            'message' => 'Новый город добавлен'
        ]);
    }

    public function renameCity()
    {
        $nameCity = $this->request->get("new_name");
        $cityId = $this->request->get("id");
        $city = $this
            ->em
            ->getRepository(Cities::class)
            ->find($cityId);

        if ($city === null) {
            return $this->json([
                'message' => "Город  не найден"
            ]);
        }
        $this->cityService->renameCity($city, $nameCity);
        return $this->json([
            'message' => "переименован "
        ]);
    }

    public function deleteCity()
    {
        $cityId = $this->request->get('city_id');
        $city = $this
            ->em
            ->getRepository(Cities::class)
            ->find($cityId);

        if (!$city) {
            return $this->json([
                'message' => 'Нет города для удаления'
            ]);
        }
        $oldCityName = $city->getName();
        $this->cityService->deleteCity($city);
        return $this->json([
            'message' => "$oldCityName удален"
        ]);
    }

    public function findCity()
    {
        $findCityId = $this->request->get('find_city_id');
        $city = $this
            ->em
            ->getRepository(Cities::class)
            ->find($findCityId);

        if (is_null($city)) {
            return $this->json([
                'message' => 'город не найден'
            ],Response::HTTP_NOT_FOUND);
        }
        return $this->json([
            'message' => "Город с ID: $findCityId {$city->getName()} "
        ]);

    }

}
