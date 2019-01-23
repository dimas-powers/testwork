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
use App\Factory\Order\OrderContext;
use App\Factory\Order\OrderFactoryInterface;
use App\Factory\Payment\InitPaymentResponseContext;
use App\Factory\Payment\InitPaymentResponseFactory;
use App\Service\Customer\CustomerService;
use App\Service\Order\Response\InitPaymentResponse;
use App\Service\SolidGateApi\Interfaces\PaymentApiInterface;
use App\Service\SolidGateApi\SolidGateApiService;
use FOS\RestBundle\Request\ParamFetcher;
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


    /**
     * OrderService constructor.
     * @param PaymentApiInterface $paymentApi
     * @param SerializerInterface $serializer
     * @param CustomerService $customerService
     * @param OrderFactoryInterface $orderFactory
     * @param InitPaymentResponseFactory $initPaymentResponseFactory
     */
    public function __construct(
        PaymentApiInterface $paymentApi,
        SerializerInterface $serializer,
        CustomerService $customerService,
        OrderFactoryInterface $orderFactory,
        InitPaymentResponseFactory $initPaymentResponseFactory
    ) {
        $this->paymentApi = $paymentApi;
        $this->customerService = $customerService;
        $this->serializer = $serializer;
        $this->customerService = $customerService;
        $this->orderFactory = $orderFactory;
        $this->initPaymentResponseFactory = $initPaymentResponseFactory;
    }

    /**
     * @param ParamFetcher $paramFetcher
     * @return InitPaymentResponse
     */
    public function proceedNewOrder(ParamFetcher $paramFetcher): InitPaymentResponse
    {
        $customer = $this->customerService->getCustomerByRequestEmail($paramFetcher);

        $orderContext = new OrderContext($paramFetcher, $customer);
        $order = $this->orderFactory->create($orderContext);

        $paymentContext = new PaymentContext($order, $customer, $paramFetcher);
        $response = $this->makePayment($paymentContext);
        $initPaymentResponseContext = new InitPaymentResponseContext(json_decode($response->getContent(),true));

        $initPaymentResponse = $this->initPaymentResponseFactory->create($initPaymentResponseContext);
        $this->customerService->setTokenToCustomer($customer, $initPaymentResponse);
        $this->customerService->eraseCredentials($customer, $initPaymentResponse);

        return $initPaymentResponse;
    }


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
        return $this->getApi()->initPayment((array) $context);
    }

    /**
     * @param array $attributes
     * @return Response
     */
    public function makeCharge(array $attributes): Response
    {
        return $this->getApi()->charge($attributes);
    }

    /**
     * @param array $attributes
     * @return Response
     */
    public function getOrderStatus(array $attributes): Response
    {
        return $this->getApi()->status($attributes);
    }
}