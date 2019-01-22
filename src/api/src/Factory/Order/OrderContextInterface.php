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

interface OrderContextInterface
{
    public function getAmount(): int;

    public function getCurrency(): string;

    public function getCustomer(): Customer;

    public function getOrderDescription(): string;

    public function getGeoCountry(): string;

    public function getIpAddress(): string;

    public function getPlatform(): string;
}