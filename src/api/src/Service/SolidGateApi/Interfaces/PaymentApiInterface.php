<?php
/**
 * Created by PhpStorm.
 * User: dmytro
 * Date: 21.01.19
 * Time: 23:35
 */

declare(strict_types=1);

namespace App\Service\SolidGateApi\Interfaces;
/**
 * Interface PaymentApiInterface
 * @package App\Service\SolidGateApi\Interfaces
 */
interface PaymentApiInterface
{
    /**
     * @param array $attributes
     * @return array
     */
    public function initPayment(array $attributes): array;

    /**
     * @param array $attributes
     * @return array
     */
    public function charge(array $attributes): array;

    /**
     * @param array $attributes
     * @return array
     */
    public function status(array $attributes): array;
}