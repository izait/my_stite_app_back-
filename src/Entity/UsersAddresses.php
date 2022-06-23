<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bundle\MakerBundle\Str;

/**
 * UsersAddresses
 *
 * @ORM\Table(name="users_addresses")
 * @ORM\Entity
 */
class UsersAddresses
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
     * @ORM\ManyToOne(targetEntity = "Users")
     * @ORM\JoinColumn(name = "users_id", referencedColumnName = "id")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity = "Cities")
     * @ORM\JoinColumn(name = "city_id", referencedColumnName = "id")
     */
    private $city;

    /**
     * @ORM\ManyToOne(targetEntity = "Streets")
     * @ORM\JoinColumn(name = "street_id", referencedColumnName = "id")
     */
    private $street;

    public function getId(): ?int
    {
        return $this->id;
    }


    public function getUser():Users{
        return $this->user;
    }

    public function setUser(Users $user):self{
        $this->user = $user;

        return $this;
    }

    public function getCity():Cities
    {
        return $this->city;
    }


    public function setCity(Cities $city): self
    {
        $this->city = $city;
        return $this;
    }

    public function getStreet():Streets
    {
        return $this->street;
    }

    public function setStreet(Streets $street): self
    {
        $this->street = $street;
        return $this;
    }


}
