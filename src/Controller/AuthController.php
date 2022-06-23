<?php

namespace App\Controller;

use App\Entity\Users;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;


class AuthController extends AbstractController
{
    private $request;
    private $em;

    public function __construct(RequestStack $requestStack, EntityManagerInterface $entityManager)
    {
        $this->request = $requestStack->getCurrentRequest();
        $this->em = $entityManager;
    }
    public function check(){
        $loginUser= $this->request->get('login');
        $passUser = $this->request->get('pass');

        if(!$loginUser || !$passUser ){
            return $this->json([
                'message' => "Не введен логин или пароль"
            ],Response::HTTP_NOT_FOUND);
        }

        /** @var Users $userDoesExist */
        $userDoesExist = $this
            ->em
            ->getRepository(Users::class)
            ->findOneBy([
                'name' => $loginUser,
                'pass' => $passUser
            ]);

        if(is_null($userDoesExist)){
            $this->json([
                'message' => "Неправильный логин или пароль"
            ],Response::HTTP_UNAUTHORIZED);
        }

        return $this->json([
            'token' => $userDoesExist->getToken(),
            'role' => $userDoesExist->getRole()
        ]);
    }
}