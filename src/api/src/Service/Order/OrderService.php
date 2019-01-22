<?php

declare(strict_types=1);

/**
 * Created by PhpStorm.
 * User: dmytro
 * Date: 20.01.19
 * Time: 19:24
 */

namespace App\Service\Order;

use App\Controller\OrderController;
use App\Entity\Order;
use App\Service\SolidGateApi\Interfaces\PaymentApiInterface;
use App\Service\SolidGateApi\SolidGateApiService;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Response;

class OrderService
{

    /**
     * @var PaymentApiInterface $paymentApi
     */
    private $paymentApi;

    /**
     * @var SerializerInterface
     */
    protected $serializer;

    /**
     * OrderService constructor.
     */
    public function __construct(PaymentApiInterface $paymentApi, SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
        $this->paymentApi = $paymentApi;
    }

//    public function cardPayment()
//    {
//        $response = $this->orderController->getOrderAction();
//
//        var_dump($response->getStatusCode());die();
//
//        if ($response->getStatusCode() !== 200) {
//            throw new SynchronizerServiceApiException('Cant get balance.');
//        }
//
//        /** @var BalanceResponse $balanceResponse */
//        $balanceResponse = $this->serializer->deserialize((string)$response->getBody(), BalanceResponse::class, 'json');
//
//        if ($balanceResponse->getStatus() !== true) {
//            throw new SynchronizerServiceApiException($balanceResponse->getError());
//        }
//    }


    /**
     * @return PaymentApiInterface
     */
    public function getApi(): PaymentApiInterface
    {
        return $this->paymentApi;
    }

    /**
     * @param PaymentApiInterface $paymentApi
     */
    public function setApi(PaymentApiInterface $paymentApi): void
    {
        $this->paymentApi = $paymentApi;
    }

    /**
     * @param PaymentContext $context
     * @return Response
     */
    public function makePayment(PaymentContext $context): Response
    {
        return $this->getApi()->initPayments((array) $context);
    }

    /**
     * @param array $attributes
     * @return Response
     */
    public function makeCharge(array $attributes): Response
    {
        return $this->getApi()->charges($attributes);
    }

    /**
     * @param array $attributes
     * @return Response
     */
    public function getOrderStatus(array $attributes): Response
    {
        return $this->getApi()->orderStatus($attributes);
    }
}