<?php

declare(strict_types=1);

/**
 * Created by PhpStorm.
 * User: dmytro
 * Date: 20.01.19
 * Time: 19:24
 */

namespace App\Service\Order;

use App\Entity\Customer;
use App\Entity\Order;
use App\Exception\CustomerException;
use App\Exception\OrderException;
use App\Factory\Charge\ChargeResponseContext;
use App\Factory\Charge\ChargeResponseFactory;
use App\Factory\Order\OrderContext;
use App\Factory\Order\OrderFactoryInterface;
use App\Factory\OrderStatus\OrderStatusResponseContext;
use App\Factory\OrderStatus\OrderStatusResponseFactory;
use App\Factory\Payment\InitPaymentResponseContext;
use App\Factory\Payment\InitPaymentResponseFactory;
use App\Factory\Recurring\RecurringResponseContext;
use App\Factory\Recurring\RecurringResponseFactory;
use App\Factory\Refund\RefundResponseContext;
use App\Factory\Refund\RefundResponseFactory;
use App\Service\Customer\CustomerService;
use App\Service\Order\Response\ChargeResponse;
use App\Service\Order\Response\InitPaymentResponse;
use App\Service\Order\Response\OrderStatusResponse;
use App\Service\Order\Response\RecurringResponse;
use App\Service\Order\Response\RefundResponse;
use App\Service\SolidGateApi\Interfaces\PaymentApiInterface;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Request\ParamFetcher;
use Symfony\Component\Serializer\SerializerInterface;

class OrderService
{
    const STATUS_APPROVED = 'approved';
    const STATUS_DECLINED = 'declined';
    const STATUS_REFUNDED = 'refunded';

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
     * @var ChargeResponseFactory
     */
    private $chargeResponseFactory;

    /**
     * @var RecurringResponseFactory
     */
    private $recurringResponseFactory;

    /**
     * @var RefundResponseFactory
     */
    private $refundResponseFactory;

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
     * @param ChargeResponseFactory $chargeResponseFactory
     * @param RecurringResponseFactory $recurringResponseFactory
     * @param RefundResponseFactory $refundResponseFactory
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        PaymentApiInterface $paymentApi,
        SerializerInterface $serializer,
        CustomerService $customerService,
        OrderFactoryInterface $orderFactory,
        InitPaymentResponseFactory $initPaymentResponseFactory,
        OrderStatusResponseFactory $orderStatusResponseFactory,
        ChargeResponseFactory $chargeResponseFactory,
        RecurringResponseFactory $recurringResponseFactory,
        RefundResponseFactory $refundResponseFactory
    ) {
        $this->entityManager = $entityManager;
        $this->paymentApi = $paymentApi;
        $this->customerService = $customerService;
        $this->serializer = $serializer;
        $this->customerService = $customerService;
        $this->orderFactory = $orderFactory;
        $this->initPaymentResponseFactory = $initPaymentResponseFactory;
        $this->orderStatusResponseFactory = $orderStatusResponseFactory;
        $this->chargeResponseFactory = $chargeResponseFactory;
        $this->recurringResponseFactory = $recurringResponseFactory;
        $this->refundResponseFactory = $refundResponseFactory;
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
            throw new CustomerException(
                sprintf('There is no customer with email=%s',$paramFetcher->get('customer_email'))
            );
        }

        $order = $this->createNewOrder($paramFetcher, $customer);

        $paymentContext = new PaymentContext($order, $customer, $paramFetcher);
        $response = $this->makePayment($paymentContext);

        $initPaymentResponseContext = new InitPaymentResponseContext($response);
        $initPaymentResponse = $this->initPaymentResponseFactory->create($initPaymentResponseContext);

        return $initPaymentResponse;
    }

    /**
     * @param ParamFetcher $paramFetcher
     * @return ChargeResponse
     * @throws OrderException
     */
    public function proceedCharge(ParamFetcher $paramFetcher): ChargeResponse
    {
        /**
         * @var Order $order
         */
        $order = $this->getOrderByRequestId($paramFetcher);

        if ($order === null) {
            throw new OrderException(
                sprintf('There is no order with id=%d',$paramFetcher->get('order_id'))
            );
        }

        $paymentContext = new ChargeContext($paramFetcher);
        $response = $this->makeCharge($paymentContext);

        $chargeResponseContext = new ChargeResponseContext($response);
        $chargeResponse = $this->chargeResponseFactory->create($chargeResponseContext);

        $customer = $order->getCustomer();

        if ($chargeResponse->getStatus() === self::STATUS_APPROVED) {
            $this->customerService->reduceBalance($customer, $order);
        }

        return $chargeResponse;
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
        $order = $this->getOrderByRequestId($paramFetcher);

        if ($order === null) {
            throw new OrderException(
                sprintf('There is no order with id=%d',$paramFetcher->get('order_id'))
            );
        }

        $orderStatusContext = new OrderStatusContext($paramFetcher);
        $response = $this->getStatus($orderStatusContext);

        $token = $this->getToken($response);

        $orderStatusResponseContext = new OrderStatusResponseContext($response, $token);
        $orderStatusResponse = $this->orderStatusResponseFactory->create($orderStatusResponseContext);

        $customer = $order->getCustomer();

        if ($orderStatusResponse->getStatus() === self::STATUS_APPROVED) {
            $this->customerService->setTokenToCustomer($customer, $orderStatusResponse);
        }

        return $orderStatusResponse;
    }

    /**
     * @param ParamFetcher $paramFetcher
     * @return RecurringResponse
     * @throws OrderException
     */
    public function proceedRecurring(ParamFetcher $paramFetcher): RecurringResponse
    {
        /**
         * @var Order $order
         */
        $order = $this->getOrderByRequestId($paramFetcher);

        if ($order === null) {
            throw new OrderException(
                sprintf('There is no order with id=%d',$paramFetcher->get('order_id'))
            );
        }

        $recurringContext = new RecurringContext($paramFetcher);
        $response = $this->makeRecurring($recurringContext);

        $recurringResponseContext = new RecurringResponseContext($response);
        $recurringResponse = $this->recurringResponseFactory->create($recurringResponseContext);

        $customer = $order->getCustomer();

        if ($recurringResponse->getStatus() === self::STATUS_APPROVED) {
            $this->customerService->reduceBalance($customer, $order);
        }

        return $recurringResponse;
    }

    /**
     * @param ParamFetcher $paramFetcher
     * @return RefundResponse
     * @throws OrderException
     */
    public function proceedRefund(ParamFetcher $paramFetcher): RefundResponse
    {
        /**
         * @var Order $order
         */
        $order = $this->getOrderByRequestId($paramFetcher);

        if ($order === null) {
            throw new OrderException(
                sprintf('There is no order with id=%d', $paramFetcher->get('order_id'))
            );
        } elseif ($order->getAmount() !== $paramFetcher->get('amount')) {
            throw new OrderException(
                sprintf(
                    'There is difference between request and log order amount=%d', $paramFetcher->get('order_id')
                )
            );
        }

        $refundContext = new RefundContext($paramFetcher);
        $response = $this->makeRefund($refundContext);

        $refundResponseContext = new RefundResponseContext($response);
        $refundResponse = $this->refundResponseFactory->create($refundResponseContext);

        $customer = $order->getCustomer();

        if ($refundResponse->getStatus() === self::STATUS_REFUNDED) {
            $this->customerService->increaseBalance($customer, $order);
        }

        return $refundResponse;
    }

    /**
     * @param ParamFetcher $paramFetcher
     * @param Customer $customer
     * @return Order
     */
    public function createNewOrder(ParamFetcher $paramFetcher, Customer $customer): Order
    {
        $orderContext = new OrderContext($paramFetcher, $customer);
        $order = $this->orderFactory->create($orderContext);

        $this->entityManager->persist($order);
        $this->entityManager->flush();

        return $order;
    }

    /**
     * @param ParamFetcher $fetcher
     * @return Order|null
     */
    public function getOrderByRequestId(ParamFetcher $fetcher): ?Order
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
     * @param ChargeContext $context
     * @return array
     */
    public function makeCharge(ChargeContext $context): array
    {
        return $this->getApi()->charge((array) $context);
    }

    /**
     * @param OrderStatusContext $attributes
     * @return array
     */
    public function getStatus(OrderStatusContext $attributes): array
    {
        return $this->getApi()->status((array) $attributes);
    }

    /**
     * @param RecurringContext $recurringContext
     * @return array
     */
    public function makeRecurring(RecurringContext $recurringContext): array
    {
        return $this->getApi()->recurring((array) $recurringContext);
    }

    /**
     * @param RefundContext $refundContext
     * @return array
     */
    public function makeRefund(RefundContext $refundContext): array
    {
        return $this->getApi()->refund((array) $refundContext);
    }

    /**
     * @param array $response
     * @return string
     */
    private function getToken(array $response): string
    {
        $transactions = array_shift($response);
        $token = '';

        foreach ($transactions as $transaction) {
            if (isset($transaction['card']['card_token']['token'])) {
                $token = $transaction['card']['card_token']['token'];
            }
        }

        return $token;
    }
}