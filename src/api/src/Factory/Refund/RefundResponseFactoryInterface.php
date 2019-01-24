<?php
declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: Dmitriy Ivanenko
 * Date: 22.01.19
 * Time: 12:03
 */

namespace App\Factory\Refund;

use App\Service\Order\Response\RefundResponse;

interface RefundResponseFactoryInterface
{
    public function create(RefundResponseContext $chargeResponseContext): RefundResponse;
}