<?php
namespace App\Services\AuthService;

use App\Entity\Users;

interface AuthServiceInterface
{
    public function check(Users $name, Users $pas);
}