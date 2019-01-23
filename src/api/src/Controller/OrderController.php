<?php

declare(strict_types=1);

namespace App\Controller;

use App\Exception\CustomerException;
use App\Factory\Order\OrderContext;
use App\Factory\Order\OrderFactoryInterface;
use App\Factory\Payment\InitPaymentResponseContext;
use App\Factory\Payment\InitPaymentResponseFactory;
use App\Service\Customer\CustomerService;
use App\Service\Order\OrderService;
use App\Service\Order\PaymentContext;
use App\Service\Order\Response\InitPaymentResponse;
use App\Service\SolidGateApi\SolidGateApiService;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations\RequestParam;
use FOS\RestBundle\Request\ParamFetcher;
use Symfony\Component\HttpFoundation\Request;

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

    /**
     * @var InitPaymentResponseFactory
     */
    private $initPaymentResponseFactory;

    public function __construct(
        OrderService $orderService,
        SerializerInterface $serializer,
        CustomerService $customerService,
        OrderFactoryInterface $orderFactory,
        InitPaymentResponseFactory $initPaymentResponseFactory
    ) {
        $this->orderService = $orderService;
        $this->serializer = $serializer;
        $this->customerService = $customerService;
        $this->orderFactory = $orderFactory;
        $this->initPaymentResponseFactory = $initPaymentResponseFactory;
    }

    /**
     * @param ParamFetcher $paramFetcher
     *
     * @RequestParam(name="amount", requirements="\d+", nullable=true)
     * @RequestParam(name="currency", requirements="[a-z]+", default="USD")
     * @RequestParam(name="customer_email", requirements="[^@]+@[^\.]+\..+")
     * @RequestParam(name="geo_country", requirements="[A-z]+")
     * @RequestParam(name="ip_address", requirements="\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}")
     * @RequestParam(name="order_description", requirements="^[a-zA-Z0-9_ ]+")
     * @RequestParam(name="platform", requirements="[A-z]+")
     *
     * @Route("/api/order", name="order", methods={"PUT"})

     * @return Response
     */
    public function putOrder(ParamFetcher $paramFetcher): Response
    {
        $initPaymentResponse = $this->orderService->proceedNewOrder($paramFetcher);

        return new Response($this->serializer->serialize($initPaymentResponse, 'json'));
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
     * @param ParamFetcher $paramFetcher
     *
     * @QueryParam(name="order_id", requirements="\d+", nullable=true)
     *
     * @Route("/api/order-status", name="order-status", methods={"GET"})
     */
    public function getOrderStatus(ParamFetcher $paramFetcher)
    {
        $response = $this->orderService->getOrderStatus($paramFetcher);
//        var_dump($response->getContent());die();
    }
}