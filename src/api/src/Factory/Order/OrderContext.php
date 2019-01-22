<?php
declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: Dmitriy Ivanenko
 * Date: 22.01.19
 * Time: 11:57
 */

namespace App\Factory\Order;

use App\Entity\Customer;
use FOS\RestBundle\Request\ParamFetcher;

class OrderContext implements OrderContextInterface
{
    /**
     * @var int
     */
    private $amount;

    /**
     * @var string
     */
    private $currency;

    /**
     * @var Customer
     */
    private $customer;

    /**
     * @var string
     */
    private $orderDescription;

    /**
     * @var string
     */
    private $geoCountry;

    /**
     * @var string
     */
    private $ipAddress;

    /**
     * @var string
     */
    private $platform;

    public function __construct(ParamFetcher $fetcher, Customer $customer)
    {
        $this->amount = $fetcher->get('amount');
        $this->currency = $fetcher->get('currency');
        $this->customer = $customer;
        $this->orderDescription = $fetcher->get('order_description');
        $this->geoCountry = $fetcher->get('geo_country');
        $this->ipAddress = $fetcher->get('ip_address');
        $this->platform = $fetcher->get('platform');
    }

    public function getAmount(): int
    {
        return (int) $this->amount;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function getCustomer(): Customer
    {
        return $this->customer;
    }

    public function getOrderDescription(): string
    {
        return $this->orderDescription;
    }

    public function getGeoCountry(): string
    {
        return $this->geoCountry;
    }

    public function getIpAddress(): string
    {
        return $this->ipAddress;
    }

    public function getPlatform(): string
    {
        return $this->platform;
    }
}