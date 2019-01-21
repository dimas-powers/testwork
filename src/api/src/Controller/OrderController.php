<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\Order\OrderService;
use App\Service\SolidGateApi\SolidGateApiService;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Routing\Annotation\Route;

class OrderController extends AbstractFOSRestController
{
    /**
     * @var OrderService
     */
    protected $orderService;

    /**
     * @var SerializerInterface
     */
    protected $serializer;

    public function __construct(OrderService $orderService, SerializerInterface $serializer)
    {
        $this->orderService = $orderService;
        $this->serializer = $serializer;
    }

    /**
     * @Route("/api/order", name="order")
     */
    public function getOrder()
    {
        $attributes = [
            'privateKey' => '0795f79f-a045-4901-adf0-05481df6c666',
            'merchantId' => 'unicorn',
            'amount' => 1,
            'currency' => 'USD',
            'customer_email' => 'test@test.com',
            'geo_country' => 'NGR',
            'ip_address' => '178.150.56.130',
            'order_id' => 128,
            'order_description' => 'Premium package',
            'platform' => 'test'
        ];

        $response = $this->orderService->makePayment($attributes);
    }

    /**
     * @Route("/api/charge", name="charge")
     */
    public function getCharge()
    {
        $attributes = [
            'order_id' => 128,
            'amount' => 1,
            'currency' => 'USD',
            'card_number' => 4532456618142692,
            'card_holder' => 'Kurt Cruickshank',
            'card_exp_month' => 03,
            'card_exp_year' => 2021,
            'card_cvv' => 967,
            'card_pin' => 1111,
            'order_description' => 'Premium package',
            'customer_email' => 'jondou@gmail.com',
            'ip_address' => '8.8.8.8',
            'platform' => 'web',
            'geo_country' => 'GBR'
        ];

        $response = $this->orderService->makeCharge($attributes);
    }

    /**
     * @Route("/api/order-status", name="order-status")
     */
    public function getOrderStatus()
    {
        $attributes = [
            'order_id' => 128
        ];

        $response = $this->orderService->getOrderStatus($attributes);
    }
}