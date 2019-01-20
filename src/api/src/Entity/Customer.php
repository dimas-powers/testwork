<?php

declare(strict_types=1);

/**
 * Created by PhpStorm.
 * User: dmytro
 * Date: 20.01.19
 * Time: 19:43
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Customer\CustomerRepository")
 */
class Customer implements UserInterface
{
    public function __construct()
    {
        $this->balances = new ArrayCollection();
    }

    /**
     * @ORM\Id
     * @ORM\Column(type="integer", columnDefinition="BIGINT")
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $email;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $token;

    /**
     * @ORM\Column(type="integer")
     */
    private $active;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $roles;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $password;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $username;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Balance", mappedBy="customer", orphanRemoval=true)
     */
    private $balances;

    public function getId(): int
    {
        return $this->id;
    }

    public function getRoles(): ?string
    {
        return $this->roles;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email): void
    {
        $this->email = $email;
    }

    public function getToken()
    {
        return $this->token;
    }

    public function setToken($token): void
    {
        $this->token = $token;
    }

    public function getActive()
    {
        return $this->active;
    }

    public function setActive($active): void
    {
        $this->active = $active;
    }

    public function getSalt()
    {
        return null;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    /**
     * @return Collection|Balance[]
     */
    public function getBalances(): Collection
    {
        return $this->balances;
    }

    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }
}