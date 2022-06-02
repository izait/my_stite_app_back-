<?php

namespace App\Security;

use App\Entity\Users;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;

class TokenAuth extends AbstractAuthenticator
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager){
        $this->entityManager = $entityManager;
    }

    public function supports(Request $request): ?bool
    {
        return true;
    }

    public function authenticate(Request $request)
    {
        $headerName = "token";
        $userToken = $request->headers->get($headerName);
        if($userToken === null){
            throw new AuthenticationException("Пустой токен");
        }

        /** @var Users|null $user */
        $user = $this
            ->entityManager
            ->getRepository(Users::class)
            ->findOneBy([
                'token' => $userToken
            ]);

        if($user === null){
            throw new AuthenticationException("Пользователь не существует");
        }

        return new SelfValidatingPassport(new UserBadge($user->getToken()));
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        return null;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        return new JsonResponse([
            'message' => $exception->getMessage()
        ]);

    }
}