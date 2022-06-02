<?php

namespace App\Controller;

use App\Entity\Users;
use Doctrine\ORM\EntityManagerInterface;
use http\Exception\RuntimeException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpKernel\HttpKernel;

class RegistrationController extends AbstractController
{
    public function supports(Request $request): ?bool
    {
        return true;
    }
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager){
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/registration", name="app_registration")
     */
    public function  registration(Request $request){
        $headerName = "reg";
        $userReg = $request->headers->get($headerName);
        $userName = $request->query->get('Name');
        $userAge =  $request->query->get('Age');
        if ($userReg=== NULL){
            return $this->json([
                'message' => 'User not add'
            ]);
        }
        else {
            $userRole = 'ROLE_TECH';
            $userToken = random_int(100, 999);

            $user = new Users();
            $user->setName($userName);
            $user->setAge($userAge);
            $user->setRole($userRole);
            $user->setToken($userToken);

            $this->entityManager->persist($user);
            $this->entityManager->flush();

            return $this->json([
                'message' => 'User add',
                'user name' => $userName
            ]);
        }
    }

    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/RegistrationController.php',
        ]);
    }
}
