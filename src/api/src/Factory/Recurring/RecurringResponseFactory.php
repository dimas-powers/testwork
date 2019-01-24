<?php
/**
 * Created by PhpStorm.
 * User: dmytro
 * Date: 23.01.19
 * Time: 0:10
 */

namespace App\Factory\Recurring;

use App\Service\Order\Response\RecurringResponse;

class RecurringResponseFactory implements RecurringResponseFactoryInterface
{
    public function create(RecurringResponseContext $chargesResponseContext): RecurringResponse
    {
        $chargeResponse = new RecurringResponse();

        $chargeResponse->setStatus($chargesResponseContext->getStatus());

        return $chargeResponse;
    }
}