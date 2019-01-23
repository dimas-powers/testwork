<?php
declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: Dmitriy Ivanenko
 * Date: 22.01.19
 * Time: 12:03
 */

namespace App\Factory\OrderStatus;

use App\Factory\OrderStatus\OrderStatusResponseContext;
use App\Service\Order\Response\OrderStatusResponse;

interface OrderStatusResponseFactoryInterface
{
    public function create(OrderStatusResponseContext $orderStatusResponseContext): OrderStatusResponse;
}