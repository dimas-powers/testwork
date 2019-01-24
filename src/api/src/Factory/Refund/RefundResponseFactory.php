<?php
/**
 * Created by PhpStorm.
 * User: dmytro
 * Date: 23.01.19
 * Time: 0:10
 */

namespace App\Factory\Refund;

use App\Service\Order\Response\RefundResponse;

class RefundResponseFactory implements RefundResponseFactoryInterface
{
    public function create(RefundResponseContext $chargesResponseContext): RefundResponse
    {
        $chargeResponse = new RefundResponse();

        $chargeResponse->setStatus($chargesResponseContext->getStatus());

        return $chargeResponse;
    }
}