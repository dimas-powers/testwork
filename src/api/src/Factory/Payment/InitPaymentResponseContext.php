<?php
declare(strict_types=1);

/**
 * Created by PhpStorm.
 * User: dmytro
 * Date: 23.01.19
 * Time: 0:10
 */

namespace App\Factory\Payment;

class InitPaymentResponseContext implements InitPaymentResponseContextInterface
{
    private $token;
    private $order_id;
    private $status;
    private $amount;
    private $currency;
    private $fraudulent;
    private $total_fee_amount;

    /**
     * InitPaymentResponseContext constructor.
     */
    public function __construct(array $response)
    {
        if (isset($response['pay_form']['token'])) {
            $this->token = $response['pay_form']['token'];
        } elseif (isset($response['order']['order_id'])) {
            $this->amount = $response['order']['amount'];
        }
        $this->order_id = $response['order']['order_id'];
        $this->status = $response['order']['status'];
        $this->currency = $response['order']['currency'];
        $this->fraudulent = $response['order']['fraudulent'];
        $this->total_fee_amount = $response['order']['total_fee_amount'];
    }

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