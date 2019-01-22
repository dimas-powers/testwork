<?php
declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: Dmitriy Ivanenko
 * Date: 22.01.19
 * Time: 12:03
 */

namespace App\Factory\Payment;

interface InitPaymentResponseContextInterface
{
    public function getToken();
    public function getAmount();
    public function getOrderId();
    public function getStatus();
    public function getCurrency();
    public function getFraudulent();
    public function getTotalFeeAmount();

}