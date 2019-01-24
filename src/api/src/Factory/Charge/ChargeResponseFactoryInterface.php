<?php
declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: Dmitriy Ivanenko
 * Date: 22.01.19
 * Time: 12:03
 */

namespace App\Factory\Charge;

use App\Service\Order\Response\ChargeResponse;

interface ChargeResponseFactoryInterface
{
    public function create(ChargeResponseContext $chargeResponseContext): ChargeResponse;
}