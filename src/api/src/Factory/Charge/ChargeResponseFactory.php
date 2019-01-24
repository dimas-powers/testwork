<?php
/**
 * Created by PhpStorm.
 * User: dmytro
 * Date: 23.01.19
 * Time: 0:10
 */

namespace App\Factory\Charge;

use App\Service\Order\Response\ChargeResponse;

class ChargeResponseFactory implements ChargeResponseFactoryInterface
{
    public function create(ChargeResponseContext $chargesResponseContext): ChargeResponse
    {
        $chargeResponse = new ChargeResponse();

        $chargeResponse->setStatus($chargesResponseContext->getStatus());

        return $chargeResponse;
    }
}