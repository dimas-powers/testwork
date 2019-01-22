<?php
declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: Dmitriy Ivanenko
 * Date: 22.01.19
 * Time: 12:03
 */

namespace App\Factory\Order;

use App\Entity\Order;

interface OrderFactoryInterface
{
    public function create(OrderContextInterface $context): Order;
}