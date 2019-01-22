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
        $this->order_id = random_int(500,1000);//$order->getId();
        $this->order_description = $order->getDescription();
        $this->platform = $paramFetcher->get('platform');
    }
}