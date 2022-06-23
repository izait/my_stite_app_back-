<?php

namespace App\Controller;

use App\Entity\Cities;
use App\Entity\Streets;
use App\Entity\Users;
use App\Repository\UsersRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\SecurityBundle;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class ListCitiesStreetsController extends AbstractController
{
    private $entityManager;

    /** @var Users|null $user */
    private $user;

    public function __construct(EntityManagerInterface $entityManager,Security $security){
        $this->entityManager = $entityManager;

        $this->user = $security->getUser();
    }

    /**
     * @Route("/list/cities/streets", name="app_list_cities_streets")
     */
    public function index(): JsonResponse
    {
        $userRoles = $this->user->getRoles();
        $userLogin = $this->user->getName();
        if(in_array("ROLE_ADMIN",$userRoles)){
            return $this->json([
                'message' => "Hello Admin $userLogin",
                'login' => $userLogin
            ]);

        }else{
            return $this->json([
                'message' => "Hello User $userLogin",
                'login' => $userLogin
            ]);
        }

        /** @var Cities[] $cities */
        $cities = $this
            ->entityManager
            ->getRepository(Cities::class)
            ->findAll();

        $citiesArray = [];
        foreach ($cities as $city){
            $citiesArray[] = [
                'id' => $city->getId(),
                'name' => $city->getName()
            ];
        }
        /** @var Streets[] $streets */
        $streets = $this
            ->entityManager
            ->getRepository(Streets::class)
            ->findAll();
        $streetsArray = [];
        foreach ($streets as $street){
            $streetsArray[] = [
                'id' => $street->getId(),
                'name' => $street->getName()
            ];
        }
        $citiesStreetsArray = array_merge ($citiesArray,$streetsArray);
        return $this->json($citiesStreetsArray);

    }
}
