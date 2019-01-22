<?php
declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: Dmitriy Ivanenko
 * Date: 22.01.19
 * Time: 12:03
 */

namespace App\Factory\Payment;

use App\Service\Order\Response\InitPaymentResponse;

interface InitPaymentResponseFactoryInterface
{
    public function create(InitPaymentResponseContext $initPaymentResponseContext): InitPaymentResponse;
}