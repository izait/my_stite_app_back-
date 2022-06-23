<?php

namespace App\Services\UserService;

use App\Entity\Users;

interface UserServiceInterface
{
    public function createUser(string $name, int $age, string $role);

    public function renameUser(Users $user, string $newName);

    public function deleteUser(Users $user);

    public function cloneUser(Users $user);

    public function findUserById(int $userId);

    public function getAllUsers();
}