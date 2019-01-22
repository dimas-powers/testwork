<?php
declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: Dmitriy Ivanenko
 * Date: 22.01.19
 * Time: 17:24
 */

namespace App\Service\Order\Response;

class InitPaymentResponse
{
    /**
     * @var InitPayFormResponse
     */
    public $pay_form;

    /**
     * @var InitOrderResponse
     */
    public $order;

    /**
     * @return InitPayFormResponse
     */
    public function getPayForm(): InitPayFormResponse
    {
        return $this->pay_form;
    }

    /**
     * @param InitPayFormResponse $pay_form
     */
    public function setPayForm(InitPayFormResponse $pay_form): void
    {
        $this->pay_form = $pay_form;
    }

    /**
     * @return InitOrderResponse
     */
    public function getOrder(): InitOrderResponse
    {
        return $this->order;
    }

    /**
     * @param InitOrderResponse $order
     */
    public function setOrder(InitOrderResponse $order): void
    {
        $this->order = $order;
    }
}