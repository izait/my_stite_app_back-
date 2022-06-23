<?php

namespace App\Controller;

use App\Services\UserService\UserService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Security;

class UserController extends AbstractController
{
    private $request;

    private $userService;

    private $user;

    private $em;

    public function __construct(RequestStack $requestStack, UserService $userService, EntityManagerInterface $entityManager,Security $security)
    {
        $this->request = $requestStack->getCurrentRequest();
        $this->userService= $userService;
        $this->em = $entityManager;
        $this->user = $security->getUser();

    }

    public function addUser()
    {
        $nameUser = $this->request->get('name');
        $ageUser = $this->request->get('age');
        $roleUser = $this->request->get('role');

        if(
            !$nameUser ||
            !$ageUser ||
            !$roleUser
        ){
            return $this->json([
                'message' => "Пользователь не добавлен"
            ],Response::HTTP_NOT_FOUND);
        }
        $this->userService->createUser($nameUser, $ageUser, $roleUser);

        return $this->json([
            'message' => "Пользователь $nameUser добавлен"
        ]);
    }

    public function renameUser()
    {
        $newName = $this->request->get('new_name');
        $userId = $this->request->get('user_id');

        if(!$newName || !$userId){
            return $this->json([
                'message' => "Введите пользователя"
            ]);
        }

        $user = $this->userService->findUserById($userId);

        if(is_null($user)){
            return $this->json([
                'message' => "Запрашиваемый пользователь не существует"
            ],Response::HTTP_NOT_FOUND);
        }

        $oldName = $user->getName();
        $this->userService->renameUser($user, $newName);

        return $this->json([
            'message' => "Пользователь $oldName переименован в $newName"
        ]);

    }

    public function findUser()
    {
        $userId = $this->request->get('id');

        $user = $this->userService->findUserById($userId);

        if(!$user){
            return $this->json([
                'message' => "Пользователь $userId  не найден!"
            ],Response::HTTP_NOT_FOUND);
        }

        return $this->json([
            "message" => "Пользователь c ID: $userId {$user->getName()}"
        ]);

    }

    public function deleteUser()
    {
        $userId = $this->request->get('user_id');

        $user = $this->userService->findUserById($userId);

        if(!$user){
            return $this->json([
                'message' => "Пользователь: $userId  не найден!"
            ],Response::HTTP_NOT_FOUND);
        }

        $this->userService->deleteUser($user);

        return $this->json([
            'message' => "Пользователь: $userId  удалён!"
        ]);
    }
}

