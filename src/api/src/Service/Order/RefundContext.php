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
 * Class RefundContext
 * @package App\Service\Order
 */
class RefundContext
{

    public $order_id;
    public $amount;

    public function __construct(ParamFetcher $fetcher)
    {
        $this->amount = $fetcher->get('amount');
        $this->order_id = $fetcher->get('order_id');
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
}