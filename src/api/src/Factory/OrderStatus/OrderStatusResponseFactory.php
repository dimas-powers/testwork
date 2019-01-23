<?php
/**
 * Created by PhpStorm.
 * User: dmytro
 * Date: 23.01.19
 * Time: 0:10
 */

namespace App\Factory\OrderStatus;

use App\Service\Order\Response\OrderStatusResponse;

class OrderStatusResponseFactory implements OrderStatusResponseFactoryInterface
{
    public function create(OrderStatusResponseContext $orderStatusResponseContext): OrderStatusResponse
    {
        $orderStatusResponse = new OrderStatusResponse();

        $orderStatusResponse->setStatus($orderStatusResponseContext->getStatus());

        return $orderStatusResponse;
    }
}