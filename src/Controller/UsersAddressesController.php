<?php

namespace App\Controller;

use App\Entity\UsersAddresses;
use App\Services\CityService\CityServiceInterface;
use App\Services\StreetService\StreetServiceInterface;
use App\Services\UserService\UserServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;


class UsersAddressesController extends AbstractController
{
    private $request;
    private $em;
    private $userService;
    private $cityService;
    private $streetService;

//    private $ua;

    public function __construct(RequestStack $requestStack,
                                EntityManagerInterface $entityManager,
                                CityServiceInterface $cityService,
                                StreetServiceInterface $streetService,
                                UserServiceInterface $userService)
    {
        $this->em = $entityManager;
        $this->request = $requestStack->getCurrentRequest();
        $this->userService = $userService;
        $this->cityService = $cityService;
        $this->streetService = $streetService;
    }

    public function bind(){
        $userId = $this->request->get('user_id');
        $cityId = $this->request->get('city_id');
        $streetId = $this->request->get('street_id');

        $user = $this->userService->findUserById($userId);
        $city = $this->cityService->findCity($cityId);
        $street =$this->streetService->findStreet($streetId);

        if(
            is_null($user) ||
            is_null($city) ||
            is_null($street)
        ){
            return $this->json([
                'message' => "Один из запрашиваемых объектов не существует"
            ]);
        }

        $userAddress = new UsersAddresses();
        $userAddress->setUser($user);
        $userAddress->setCity($city);
        $userAddress->setStreet($street);

        $this->em->persist($userAddress);
        $this->em->flush();

        return $this->json([
            'message' => "Адрес пользователя успешно создан"
        ]);
    }

    public function replace(){
        $userAddressId = $this->request->get('user_address_id');
        $cityId = $this->request->get('city_id');
        $streetId = $this->request->get('street_id');

        $userAddress = $this
            ->em
            ->getRepository(UsersAddresses::class)
            ->find($userAddressId);

        $city = $this->cityService->findCity($cityId);
        $street =$this->streetService->findStreet($streetId);

        if(!$userAddress || !$city || !$street){
            return $this->json([
                'message' => "Один из запрашиваемых объектов не существует"
            ]);
        }

        $userAddress
            ->setCity($city)
            ->setStreet($street);

        $this->em->flush();

        return $this->json([
            'message' => "Для пользователия изменина улица и город"
        ]);
    }

    public function delete()
    {
        $userAddressId = $this->request->get('id');

        /** @var UsersAddresses|null $userAddress */
        $userAddress = $this
            ->em
            ->getRepository(UsersAddresses::class)
            ->find($userAddressId);

        if (is_null($userAddress)) {
            return $this->json([
                'message' => "Запрашиваемый адрес не существует"
            ]);
        }

        $this->em->remove($userAddress);
        $this->em->flush();

        return $this->json([
            'message' => "UserAddress с ID:{$userAddressId} удалён"
        ]);
    }

}