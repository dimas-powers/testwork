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
 * @ORM\Entity(repositoryClass="App\Repository\Balance\BalanceRepository")
 */
class Balance
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer", columnDefinition="BIGINT")
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     */
    private $id;


    /**
     * @ORM\Column(type="bigint")
     */
    private $amount;

    /**
     * @ORM\Column(type="string")
     */
    private $currency;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Customer", inversedBy="balance")
     * @ORM\JoinColumn(nullable=false)
     */
    private $customer;

    public function getId(): int
    {
        return $this->id;
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
}