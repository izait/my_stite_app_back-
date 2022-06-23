<?php

namespace App\Services\UserService;

use App\Entity\Users;

class ModernUserService implements UserServiceInterface
{
    private $em;

    public function __construct(\Doctrine\ORM\EntityManagerInterface $entityManager){
        $this->em = $entityManager;
    }

    public function createUser(string $name, int $age, string $role)
    {
        $user = new \App\Entity\Users();
        $user->setName($name);
        $user->setAge($age);
        $user->setRole($role);

        $this->em->persist($user);
        $this->em->flush();
    }

    public function renameUser(\App\Entity\Users $user, string $newName)
    {
        $user->setName($newName);

        $this->em->flush();
    }

    public function deleteUser(\App\Entity\Users $user)
    {
        $this->em->remove($user);
        $this->em->flush();
    }

    public function cloneUser(\App\Entity\Users $user)
    {
        $this->createUser($user->getName(),$user->getAge(),$user->getRole());
    }

    public function getAllUsers()
    {
        return [$this
            ->em
            ->getRepository(\App\Entity\Users::class)
            ->findAll()];
    }
    public function findUserById(int $userId)
    {
        return $this
            ->em
            ->getRepository(Users::class)
            ->find($userId);
    }
}