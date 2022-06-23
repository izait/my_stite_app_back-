<?php

namespace App\Controller;

use App\Entity\Users;
use App\Services\UserService\UserService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Symfony\Flex\Response;

class RenameController extends AbstractController
{
    private $userService;

    /** @var Users|null $user */
    private $user;

    public function __construct(Security $security,UserService $userService)
    {
        $this->userService = $userService;

        $this->user = $security->getUser();
    }

    /**
     * @Route("/rename", name="app_rename")
     */
    public function index(Request $request): JsonResponse
    {
        $newName = $request->query->get('name');

        $this->userService->renameUser($this->user,$newName);

        return $this->json([
            'message' => "{$this->user->getName()} переименован в $newName",
        ]);
        //}
    }
}
