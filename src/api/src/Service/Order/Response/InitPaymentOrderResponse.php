<?php
declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: Dmitriy Ivanenko
 * Date: 22.01.19
 * Time: 17:24
 */

namespace App\Service\Order\Response;

class InitPaymentOrderResponse
{
    /**
     * @var InitOrderResponse
     */
    protected $initOrderResponse;

    /**
     * @var InitPayFormResponse
     */
   protected $initPayFromResponse;

    /**
     * @return InitOrderResponse
     */
    public function getInitOrderResponse(): InitOrderResponse
    {
        return $this->initOrderResponse;
    }

    /**
     * @param InitOrderResponse $initOrderResponse
     */
    public function setInitOrderResponse(InitOrderResponse $initOrderResponse): void
    {
        $this->initOrderResponse = $initOrderResponse;
    }

    /**
     * @return InitPayFormResponse
     */
    public function getInitPayFromResponse(): InitPayFormResponse
    {
        return $this->initPayFromResponse;
    }

    /**
     * @param InitPayFormResponse $initPayFromResponse
     */
    public function setInitPayFromResponse(InitPayFormResponse $initPayFromResponse): void
    {
        $this->initPayFromResponse = $initPayFromResponse;
    }


}