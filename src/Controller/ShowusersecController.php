<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Cities;
use App\Entity\Streets;
use App\Entity\Users;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Request;

class ShowusersecController extends AbstractController
{
    private $entityManager;

    /** @var Users|null $user */
    private $user;

    public function __construct(EntityManagerInterface $entityManager, Security $security)
    {
        $this->entityManager = $entityManager;

        $this->user = $security->getUser();
    }
    /**
     * @Route("/showusersec", name="app_showusersec")
     */
    public function index(Request $request): JsonResponse
    {
        $userRoles = $this->user->getRoles();
        $userLogin = $this->user->getName();

        if (in_array("ROLE_ADMIN", $userRoles)) {
            /** @var Users[] $users */
            $users = $this
                ->entityManager
                ->getRepository(Users::class)
                ->findAll();

            $usersArray = [];
            foreach ($users as $user){
            $usersArray[] = [
                'id' => $user->getId(),
                'name' => $user->getName()
             ];
            }
            return $this->json($usersArray);
           // return $this->json(['message' => "Hello User $userLogin -u admin"]);

        }
        else {
            return $this->json(['message' => "Hello User $userLogin -u a not admin"]);
        }

    }
}
