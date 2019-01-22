<?php

declare(strict_types=1);

namespace App\Controller;

use App\Exception\CustomerException;
use App\Factory\Order\OrderContext;
use App\Factory\Order\OrderFactoryInterface;
use App\Service\Customer\CustomerService;
use App\Service\Order\OrderService;
use App\Service\Order\PaymentContext;
use App\Service\Order\Response\InitPayFormResponse;
use App\Service\Order\Response\InitPaymentResponse;
use App\Service\SolidGateApi\SolidGateApiService;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations\RequestParam;
use FOS\RestBundle\Request\ParamFetcher;

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

    /**
     * @var CustomerService
     */
    protected $customerService;

    /**
     * @var OrderFactoryInterface
     */
    private $orderFactory;

    public function __construct(
        OrderService $orderService,
        SerializerInterface $serializer,
        CustomerService $customerService,
        OrderFactoryInterface $orderFactory
    ) {
        $this->orderService = $orderService;
        $this->serializer = $serializer;
        $this->customerService = $customerService;
        $this->orderFactory = $orderFactory;
    }

    /**
     * @RequestParam(name="amount", requirements="\d+", nullable=true)
     * @RequestParam(name="currency", requirements="[a-z]+", default="USD")
     * @RequestParam(name="customer_email", requirements="[^@]+@[^\.]+\..+")
     * @RequestParam(name="geo_country", requirements="[A-z]+")
     * @RequestParam(name="ip_address", requirements="\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}")
     * @RequestParam(name="order_description", requirements="^[a-zA-Z0-9_ ]+")
     * @RequestParam(name="platform", requirements="[A-z]+")
     *
     * @Route("/api/order", name="order", methods={"PUT"})
     */
    public function putOrder(ParamFetcher $paramFetcher)
    {
        $customer = $this->customerService->getCustomerByRequestEmail($paramFetcher);

        if ($customer === null) {
            return ['success' => false, 'data' => ['There is no user with such email']];
        }

        $orderContext = new OrderContext($paramFetcher, $customer);
        $order = $this->orderFactory->create($orderContext);

        $paymentContext = new PaymentContext($order, $customer, $paramFetcher);
        $response = $this->orderService->makePayment($paymentContext);

        /** @var InitPaymentResponse $responseApi */
        $responseApi = $this->serializer->deserialize($response->getContent(), InitPayFormResponse::class, 'json');
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
            'order_id' => 127
        ];

        $response = $this->orderService->getOrderStatus($attributes);
        var_dump($response->getContent());die();
    }
}