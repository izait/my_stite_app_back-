<?php

namespace App\Controller;

use App\Entity\Streets;
use App\Services\StreetService\StreetServiceInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\MakerBundle\Str;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StreetsController extends AbstractController
{
    private $request;

    private $streetService;

    private $em;

    public function __construct(RequestStack $requestStack, StreetServiceInterface $streetService, EntityManagerInterface $entityManager)
    {
        $this->request = $requestStack->getCurrentRequest();
        $this->streetService = $streetService;
        $this->em = $entityManager;
    }

    public function addStreet()
    {
        $newStreetName = $this->request->get('name_street');
        if ($newStreetName === null) {
            return $this->json([
                'message' => "Введите улицу"
            ]);
        }
        $this->streetService->createStreet($newStreetName);
        return $this->json([
            "message" => "Улица  {$newStreetName} добавлена!"
        ]);
    }

    public function renameStreet()
    {
        $streetId = $this->request->get('street_id');
        $streetNewName = $this->request->get('name');

        /** @var Streets|null $street */
        $street = $this
            ->em
            ->getRepository(Streets::class)
            ->find($streetId);

        if ($street === null) {
            return $this->json([
                'message' => "Запрашиваемая улица не существует!"
            ],Response::HTTP_NOT_FOUND);
        }

        $this->streetService->renameStreet($street, $streetNewName);

        return $this->json([
            "message" => "Улица была переименована в {$street->getName()}"
        ]);
    }

    public function deleteStreet()
    {
        $streetId = $this->request->get('street_id');
        $street = $this
            ->em
            ->getRepository(Streets::class)
            ->find($streetId);

        if ($street === null) {
            return $this->json([
                "message" => "Улица $streetId не найдена"
            ],Response::HTTP_NOT_FOUND);
        }
        $oldStreetName = $street->getName();
        $this->streetService->deleteStreet($street);
        return $this->json([
            "message" => "Улица $oldStreetName удалена"
        ]);
    }

    public function findStreet()
    {
        $streetIds = $this->request->get('id');

        $street = $this->streetService->findStreet($streetIds);

        if (!$street) {
            return $this->json([
                "message" => "Улица c ID: $streetIds  не найдена"
            ],Response::HTTP_NOT_FOUND);
        }

        return $this->json([
            "message" => "Улица c ID: $streetIds {$street->getName()}"
        ]);
    }
}
