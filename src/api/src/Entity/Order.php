<?php

declare(strict_types=1);

/**
 * Created by PhpStorm.
 * User: dmytro
 * Date: 20.01.19
 * Time: 19:44
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Order\OrderRepository")
 * @ORM\Table(name="orders")
 */
class Order
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer", columnDefinition="BIGINT")
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $description;

    /**
     * @ORM\Column(type="bigint")
     */
    private $amount;

    /**
     * @ORM\Column(type="string")
     */
    private $currency;

    /**
     * @ORM\Column(type="string")
     */
    private $geoCountry;

    /**
     * @ORM\Column(type="string")
     */
    private $ipAddress;

    /**
     * @ORM\Column(type="string")
     */
    private $platform;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Customer")
     * @ORM\JoinColumn(nullable=false)
     */
    private $customer;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $status;

    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description): void
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param mixed $amount
     */
    public function setAmount($amount): void
    {
        $this->amount = $amount;
    }

    /**
     * @return string
     */
    public function getCurrency(): string
    {
        return $this->currency;
    }

    /**
     * @param mixed $currency
     */
    public function setCurrency($currency): void
    {
        $this->currency = $currency;
    }

    /**
     * @return Customer|null
     */
    public function getCustomer(): ?Customer
    {
        return $this->customer;
    }

    /**
     * @param Customer|null $customer
     * @return self
     */
    public function setCustomer(?Customer $customer): self
    {
        $this->customer = $customer;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getGeoCountry()
    {
        return $this->geoCountry;
    }

    /**
     * @param mixed $geoCountry
     */
    public function setGeoCountry($geoCountry): void
    {
        $this->geoCountry = $geoCountry;
    }

    /**
     * @return mixed
     */
    public function getIpAddress()
    {
        return $this->ipAddress;
    }

    /**
     * @param mixed $ipAddress
     */
    public function setIpAddress($ipAddress): void
    {
        $this->ipAddress = $ipAddress;
    }

    /**
     * @return mixed
     */
    public function getPlatform()
    {
        return $this->platform;
    }

    /**
     * @param mixed $platform
     */
    public function setPlatform($platform): void
    {
        $this->platform = $platform;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status): void
    {
        $this->status = $status;
    }
}