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
use App\Exception\CustomerException;
use App\Exception\OrderException;
use App\Factory\Order\OrderContext;
use App\Factory\Order\OrderFactoryInterface;
use App\Factory\OrderStatus\OrderStatusResponseContext;
use App\Factory\OrderStatus\OrderStatusResponseFactory;
use App\Factory\Payment\InitPaymentResponseContext;
use App\Factory\Payment\InitPaymentResponseFactory;
use App\Service\Customer\CustomerService;
use App\Service\Order\Response\InitPaymentResponse;
use App\Service\Order\Response\OrderStatusResponse;
use App\Service\SolidGateApi\Interfaces\PaymentApiInterface;
use App\Service\SolidGateApi\SolidGateApiService;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Request\ParamFetcher;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Response;

class OrderService
{
    const STATUS_APPROVED = 'approved';
    const STATUS_DECLINED = 'declined';

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
     * @var OrderStatusResponseFactory
     */
    private $orderStatusResponseFactory;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * OrderService constructor.
     * @param EntityManagerInterface $entityManager
     * @param PaymentApiInterface $paymentApi
     * @param SerializerInterface $serializer
     * @param CustomerService $customerService
     * @param OrderFactoryInterface $orderFactory
     * @param InitPaymentResponseFactory $initPaymentResponseFactory
     * @param OrderStatusResponseFactory $orderStatusResponseFactory
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        PaymentApiInterface $paymentApi,
        SerializerInterface $serializer,
        CustomerService $customerService,
        OrderFactoryInterface $orderFactory,
        InitPaymentResponseFactory $initPaymentResponseFactory,
        OrderStatusResponseFactory $orderStatusResponseFactory
    ) {
        $this->entityManager = $entityManager;
        $this->paymentApi = $paymentApi;
        $this->customerService = $customerService;
        $this->serializer = $serializer;
        $this->customerService = $customerService;
        $this->orderFactory = $orderFactory;
        $this->initPaymentResponseFactory = $initPaymentResponseFactory;
        $this->orderStatusResponseFactory = $orderStatusResponseFactory;
    }

    /**
     * @param ParamFetcher $paramFetcher
     * @return InitPaymentResponse
     * @throws CustomerException
     */
    public function proceedNewOrder(ParamFetcher $paramFetcher): InitPaymentResponse
    {
        $customer = $this->customerService->getCustomerByRequestEmail($paramFetcher);

        if ($customer === null) {
            throw new CustomerException('There is no customer with such email');
        }

        $orderContext = new OrderContext($paramFetcher, $customer);
        $order = $this->orderFactory->create($orderContext);

        $paymentContext = new PaymentContext($order, $customer, $paramFetcher);
        $response = $this->makePayment($paymentContext);

        $initPaymentResponseContext = new InitPaymentResponseContext($response);
        $initPaymentResponse = $this->initPaymentResponseFactory->create($initPaymentResponseContext);

        return $initPaymentResponse;
    }

    /**
     * @param ParamFetcher $paramFetcher
     * @return OrderStatusResponse
     * @throws OrderException
     */
    public function getOrderStatus(ParamFetcher $paramFetcher): OrderStatusResponse
    {
        /**
         * @var Order $order
         */
        $order = $this->getOrderByRequestEmail($paramFetcher);

        if ($order === null) {
            throw new OrderException('There is no order with such id');
        }

        $orderStatusContext = new OrderStatusContext($paramFetcher);
        $response = $this->getStatus($orderStatusContext);

        $orderStatusResponseContext = new OrderStatusResponseContext($response);
        $orderStatusResponse = $this->orderStatusResponseFactory->create($orderStatusResponseContext);

        $customer = $order->getCustomer();

        if ($orderStatusResponse->getStatus() === self::STATUS_APPROVED) {
            $this->customerService->setTokenToCustomer($customer, $order);
            $this->customerService->eraseCredentials($customer, $order);
        }

        return $orderStatusResponse;
    }

    /**
     * @param ParamFetcher $fetcher
     * @return Order|null
     */
    public function getOrderByRequestEmail(ParamFetcher $fetcher): ?Order
    {
        $orderId = $fetcher->get('order_id');

        return $this->entityManager->getRepository(Order::class)->findOneBy(['id' => $orderId]);
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
     * @return array
     */
    public function makePayment(PaymentContext $context): array
    {
        return $this->getApi()->initPayment((array) $context);
    }

    /**
     * @param array $attributes
     * @return array
     */
    public function makeCharge(array $attributes): array
    {
        return $this->getApi()->charge($attributes);
    }

    /**
     * @param OrderStatusContext $attributes
     * @return array
     */
    public function getStatus(OrderStatusContext $attributes): array
    {
        return $this->getApi()->status((array) $attributes);
    }
}