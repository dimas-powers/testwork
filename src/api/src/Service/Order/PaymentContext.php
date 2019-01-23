<?php
declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: Dmitriy Ivanenko <d.ivanenko@minexsystems.com>
 * Date: 22.01.19
 * Time: 17:43
 */

namespace App\Service\Order;

use App\Entity\Customer;
use App\Entity\Order;
use FOS\RestBundle\Request\ParamFetcher;

class PaymentContext
{
    public $amount;
    public $currency;
    public $customer_email;
    public $geo_country;
    public $ip_address;
    public $order_id;
    public $order_description;
    public $platform;

    public function __construct(Order $order, Customer $customer, ParamFetcher $paramFetcher)
    {
        $this->amount = $order->getAmount();
        $this->currency = $order->getCurrency();
        $this->customer_email = $customer->getEmail();
        $this->geo_country = $paramFetcher->get('geo_country');
        $this->ip_address = $paramFetcher->get('ip_address');
        $this->order_id = random_int(999,99999);
        $this->order_description = $order->getDescription();
        $this->platform = $paramFetcher->get('platform');
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
     * @param string $currency
     */
    public function setCurrency(string $currency): void
    {
        $this->currency = $currency;
    }

    /**
     * @return mixed
     */
    public function getCustomerEmail()
    {
        return $this->customer_email;
    }

    /**
     * @param mixed $customer_email
     */
    public function setCustomerEmail($customer_email): void
    {
        $this->customer_email = $customer_email;
    }

    /**
     * @return mixed
     */
    public function getGeoCountry()
    {
        return $this->geo_country;
    }

    /**
     * @param mixed $geo_country
     */
    public function setGeoCountry($geo_country): void
    {
        $this->geo_country = $geo_country;
    }

    /**
     * @return mixed
     */
    public function getIpAddress()
    {
        return $this->ip_address;
    }

    /**
     * @param mixed $ip_address
     */
    public function setIpAddress($ip_address): void
    {
        $this->ip_address = $ip_address;
    }

    /**
     * @return int
     */
    public function getOrderId(): int
    {
        return $this->order_id;
    }

    /**
     * @param int $order_id
     */
    public function setOrderId(int $order_id): void
    {
        $this->order_id = $order_id;
    }

    /**
     * @return mixed
     */
    public function getOrderDescription()
    {
        return $this->order_description;
    }

    /**
     * @param mixed $order_description
     */
    public function setOrderDescription($order_description): void
    {
        $this->order_description = $order_description;
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
}