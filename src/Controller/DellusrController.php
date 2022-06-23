<?php

namespace App\Controller;


use App\Entity\Users;
use App\Services\UserService\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Security;

class DellusrController extends AbstractController
{
    private $userService;

    /** @var Users|null $user */
    private $user;

    public function __construct(Security $security,UserService  $userService)
    {
        $this->userService = $userService;
        $this->user = $security->getUser();
    }

    public function index(): JsonResponse
    {
        $this->userService->deleteUser($this->user);

        return $this->json([
            'message' => "{$this->user->getName()} удален",
        ]);
    }
}
