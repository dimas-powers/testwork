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
 * Class OrderStatusContext
 * @package App\Service\Order
 */
class ChargeContext
{

    public $order_id;
    public $amount;
    public $currency;
    public $card_number;
    public $card_holder;
    public $card_exp_month;
    public $card_exp_year;
    public $card_cvv;
    public $card_pin;
    public $order_description;
    public $customer_email;
    public $ip_address;
    public $platform;
    public $geo_country;

    public function __construct(ParamFetcher $fetcher)
    {
        $this->amount = (int) $fetcher->get('amount');
        $this->order_id = $fetcher->get('order_id');
        $this->currency = $fetcher->get('currency');
        $this->card_number = $fetcher->get('card_number');
        $this->card_holder = $fetcher->get('card_holder');
        $this->card_exp_month = $fetcher->get('card_exp_month');
        $this->card_exp_year = $fetcher->get('card_exp_year');
        $this->card_cvv = $fetcher->get('card_cvv');
        $this->card_pin = $fetcher->get('card_pin');
        $this->order_description = $fetcher->get('order_description');
        $this->customer_email = $fetcher->get('customer_email');
        $this->ip_address = $fetcher->get('ip_address');
        $this->platform = $fetcher->get('platform');
        $this->geo_country = $fetcher->get('geo_country');
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
    public function getCardNumber()
    {
        return (int) $this->card_number;
    }

    /**
     * @param mixed $card_number
     */
    public function setCardNumber($card_number): void
    {
        $this->card_number = $card_number;
    }

    /**
     * @return mixed
     */
    public function getCardHolder()
    {
        return $this->card_holder;
    }

    /**
     * @param mixed $card_holder
     */
    public function setCardHolder($card_holder): void
    {
        $this->card_holder = $card_holder;
    }

    /**
     * @return mixed
     */
    public function getCardExpMonth()
    {
        return (int) $this->card_exp_month;
    }

    /**
     * @param mixed $card_exp_month
     */
    public function setCardExpMonth($card_exp_month): void
    {
        $this->card_exp_month = $card_exp_month;
    }

    /**
     * @return mixed
     */
    public function getCardExpYear()
    {
        return (int) $this->card_exp_year;
    }

    /**
     * @param mixed $card_exp_year
     */
    public function setCardExpYear($card_exp_year): void
    {
        $this->card_exp_year = $card_exp_year;
    }

    /**
     * @return mixed
     */
    public function getCardCvv()
    {
        return (int) $this->card_cvv;
    }

    /**
     * @param mixed $card_cvv
     */
    public function setCardCvv($card_cvv): void
    {
        $this->card_cvv = $card_cvv;
    }

    /**
     * @return mixed
     */
    public function getCardPin()
    {
        return $this->card_pin;
    }

    /**
     * @param mixed $card_pin
     */
    public function setCardPin($card_pin): void
    {
        $this->card_pin = $card_pin;
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
}