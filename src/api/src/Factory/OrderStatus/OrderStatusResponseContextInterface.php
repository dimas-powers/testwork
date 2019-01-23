<?php
declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: Dmitriy Ivanenko
 * Date: 22.01.19
 * Time: 12:03
 */

namespace App\Factory\OrderStatus;

interface OrderStatusResponseContextInterface
{
    public function getStatus();
}