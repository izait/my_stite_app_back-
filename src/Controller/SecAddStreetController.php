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

class SecAddStreetController extends AbstractController
{
    private $entityManager;

    /** @var Users|null $user */
    private $user;

    public function __construct(EntityManagerInterface $entityManager, Security $security)
    {
        $this->entityManager = $entityManager;

        $this->user = $security->getUser();
    }

    public function index(Request $request): JsonResponse
    {
        $userRoles = $this->user->getRoles();
        $userLogin = $this->user->getName();

        if (in_array("ROLE_ADMIN", $userRoles)) {

            $headerName = 'street';
            $streetAdd = $request->headers->get($headerName);
            $streetName = $request->query->get('name');

            if ($streetAdd  === NULL){
                return $this->json([
                    'message' => 'Street not add'
                ]);
            }
            else {
                $street = new Streets();
                $street->setName($streetName);

                $this->entityManager->persist($street);
                $this->entityManager->flush();

                return $this->json([
                    'message' => 'Street add',
                    'street name' => $streetName
                ]);
            }

        } else {
            return $this->json([
                'message' => "Hello User $userLogin -u a not admin"
            ]);
        }

    }
}
