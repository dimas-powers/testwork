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
    protected $token;
    protected $order_id;
    protected $status;
    protected $amount;
    protected $currency;
    protected $fraudulent;
    protected $total_fee_amount;

    /**
     * @return mixed
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param mixed $token
     */
    public function setToken($token): void
    {
        $this->token = $token;
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

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status): void
    {
        $this->status = $status;
    }

    /**
     * @return mixed
     */
    public function getAmount()
    {
        return $this->amount;
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
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * @param mixed $currency
     */
    public function setCurrency($currency): void
    {
        $this->currency = $currency;
    }

    /**
     * @return mixed
     */
    public function getFraudulent()
    {
        return $this->fraudulent;
    }

    /**
     * @param mixed $fraudulent
     */
    public function setFraudulent($fraudulent): void
    {
        $this->fraudulent = $fraudulent;
    }

    /**
     * @return mixed
     */
    public function getTotalFeeAmount()
    {
        return $this->total_fee_amount;
    }

    /**
     * @param mixed $total_fee_amount
     */
    public function setTotalFeeAmount($total_fee_amount): void
    {
        $this->total_fee_amount = $total_fee_amount;
    }


}