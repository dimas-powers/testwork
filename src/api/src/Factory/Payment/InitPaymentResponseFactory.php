<?php
/**
 * Created by PhpStorm.
 * User: dmytro
 * Date: 23.01.19
 * Time: 0:10
 */

namespace App\Factory\Payment;

use App\Factory\Payment\InitPaymentResponseFactoryInterface;
use App\Service\Order\Response\InitPaymentResponse;

class InitPaymentResponseFactory implements InitPaymentResponseFactoryInterface
{
    public function create(InitPaymentResponseContext $initPaymentResponseContext): InitPaymentResponse
    {
        $initPaymentResponse = new InitPaymentResponse();

        $initPaymentResponse->setToken($initPaymentResponseContext->getToken());
        $initPaymentResponse->setAmount($initPaymentResponseContext->getAmount());
        $initPaymentResponse->setOrderId($initPaymentResponseContext->getOrderId());
        $initPaymentResponse->setStatus($initPaymentResponseContext->getStatus());
        $initPaymentResponse->setCurrency($initPaymentResponseContext->getCurrency());
        $initPaymentResponse->setFraudulent($initPaymentResponseContext->getFraudulent());
        $initPaymentResponse->setTotalFeeAmount($initPaymentResponseContext->getTotalFeeAmount());

        return $initPaymentResponse;
    }
}