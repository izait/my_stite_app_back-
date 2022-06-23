<?php

namespace App\Services\AuthService;
use App\Entity\Users;

class AuthService implements AuthServiceInterface
{
    private $em;

    public function __construct(\Doctrine\ORM\EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }

    public function check(Users $name, Users $pas)
    {

    }
}