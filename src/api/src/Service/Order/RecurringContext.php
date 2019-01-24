<?php
declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: Dmitriy Ivanenko
 * Date: 22.01.19
 * Time: 11:57
 */

namespace App\Service\Order;

use FOS\RestBundle\Request\ParamFetcher;

/**
 * Class RecurringContext
 * @package App\Service\Order
 */
class RecurringContext
{

    public $order_id;
    public $amount;
    public $currency;
    public $recurring_token;
    public $order_description;
    public $customer_email;
    public $ip_address;
    public $platform;

    public function __construct(ParamFetcher $fetcher)
    {
        $this->amount = (int) $fetcher->get('amount');
        $this->order_id = $fetcher->get('order_id');
        $this->currency = $fetcher->get('currency');
        $this->recurring_token = $fetcher->get('recurring_token');
        $this->order_description = $fetcher->get('order_description');
        $this->customer_email = $fetcher->get('customer_email');
        $this->ip_address = $fetcher->get('ip_address');
        $this->platform = $fetcher->get('platform');
    }

    /**
     * @return int
     */
    public function getAmount(): int
    {
        return (int) $this->amount;
    }

    /**
     * @param mixed $amount
     */
    public function setAmount($amount): void
    {
        $this->amount = $amount;
    }

    /**
     * @return mixed
     */
    public function getOrderId()
    {
        return $this->order_id;
    }

    /**
     * @param mixed $order_id
     */
    public function setOrderId($order_id): void
    {
        $this->order_id = $order_id;
    }



    /**
     * @return mixed
     */
    public function getCurrency()
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
     * @return mixed
     */
    public function getRecurringToken()
    {
        return $this->recurring_token;
    }

    /**
     * @param mixed $recurring_token
     */
    public function setRecurringToken($recurring_token): void
    {
        $this->recurring_token = $recurring_token;
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