<?php

namespace App\Services\UserService;

use App\Entity\Users;

class UserService implements UserServiceInterface
{
    private $em;

    public function __construct(\Doctrine\ORM\EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }

    public function createUser(string $name, int $age, string $role)
    {
        $token = bin2hex(random_bytes(3));
        $user = new Users();
        $user->setName($name);
        $user->setAge($age);
        $user->setRole($role);
        $user->setToken($token);

        $this->em->persist($user);
        $this->em->flush();
    }

    public function renameUser(Users $user, string $newName)
    {
        $user->setName($newName);

        $this->em->flush();
    }

    public function deleteUser(Users $user)
    {
        $this->em->remove($user);
        $this->em->flush();
    }

    public function cloneUser(Users $user)
    {
        $newUser = new Users();
        $newUser->setName($user->getName());
        $newUser->setAge($user->getAge());
        $newUser->setRole($user->getRole());

        $this->em->persist($newUser);
        $this->em->flush();
    }

    public function getAllUsers()
    {
        return $this
            ->em
            ->getRepository(Users::class)
            ->findAll();
    }
    public function findUserById(int $userId)
    {
        return $this
            ->em
            ->getRepository(Users::class)
            ->find($userId);
    }
}