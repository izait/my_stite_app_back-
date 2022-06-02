<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Users
 *
 * @ORM\Table(name="users")
 * @ORM\Entity(repositoryClass="App\Repository\UsersRepository")
 */
class Users implements UserInterface
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=30, nullable=false, options={"fixed"=true})
     */
    private $name;

    /**
     * @var int
     *
     * @ORM\Column(name="age", type="integer", nullable=false)
     */
    private $age;

    /**
     * @var string
     *
     * @ORM\Column(name="token", type="string", length=250, nullable=false, options={"fixed"=true})
     */
    private $token;


    /**
    * @ORM\Column(name="role", type="string", length=250, nullable=false)
    */
    private $role;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(int $age): self
    {
        $this->age = $age;

        return $this;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(string $token): self
    {
        $this->token = $token;

        return $this;
    }

    public function getRole():string{
        return $this->role;
    }

    public function setRole(string $role):self{
        $this->role = $role;

        return $this;
    }


    public function getRoles()
    {
        $defaultRoles = ['ROLE_USER'];
        $customRoles = [$this->getRole()];

        return array_merge($defaultRoles,$customRoles);
    }

    public function getPassword()
    {
        return null;
    }

    public function getSalt()
    {
        return md5(random_bytes(16));
    }

    public function eraseCredentials()
    {
    }

    public function getUsername()
    {
        return $this->getName();
    }

    public function __call($name, $arguments)
    {
    }
}
