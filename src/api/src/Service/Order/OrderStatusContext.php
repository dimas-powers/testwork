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
class OrderStatusContext
{
    /**
     * @var int
     */
    public $order_id;


    public function __construct(ParamFetcher $fetcher)
    {
        $this->order_id = $fetcher->get('order_id');
    }

    public function getOrderId(): int
    {
        return (int) $this->order_id;
    }

    /**
     * @param int $order_id
     */
    public function setOrderId(int $order_id): void
    {
        $this->order_id = $order_id;
    }

}