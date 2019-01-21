<?php
/**
 * Created by PhpStorm.
 * User: dmytro
 * Date: 21.01.19
 * Time: 23:35
 */

declare(strict_types=1);

namespace App\Service\SolidGateApi\Interfaces;

use Symfony\Component\HttpFoundation\Response;

interface PaymentApiInterface
{
    /**
     * @param array $attributes
     * @return Response
     */
    public function initPayments(array $attributes): Response;

    /**
     * @param array $attributes
     * @return Response
     */
    public function charges(array $attributes): Response;

    /**
     * @param array $attributes
     * @return Response
     */
    public function orderStatus(array $attributes): Response;
}