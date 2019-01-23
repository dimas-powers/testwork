<?php

declare(strict_types=1);

namespace App\Controller;

use App\Exception\CustomerException;
use App\Factory\Order\OrderFactoryInterface;
use App\Factory\Payment\InitPaymentResponseFactory;
use App\Service\Customer\CustomerService;
use App\Service\Order\OrderService;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations\QueryParam;
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
     * @RequestParam(name="amount", requirements="\d+")
     * @RequestParam(name="currency", requirements="[a-z]+", default="USD")
     * @RequestParam(name="customer_email", requirements="[^@]+@[^\.]+\..+")
     * @RequestParam(name="geo_country", requirements="[A-z]+")
     * @RequestParam(name="ip_address", requirements="\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}")
     * @RequestParam(name="order_description", requirements="^[a-zA-Z0-9_ ]+")
     * @RequestParam(name="platform", requirements="[A-z]+")
     *
     * @Route("/api/order", name="order", methods={"PUT"})
     *
     * @return Response
     * @throws CustomerException
     */
    public function putOrder(ParamFetcher $paramFetcher): Response
    {
        $initPaymentResponse = $this->orderService->proceedNewOrder($paramFetcher);

        return new Response($this->serializer->serialize($initPaymentResponse, 'json'));
    }

    /**
     * @param ParamFetcher $paramFetcher
     *
     * @QueryParam(name="order_id", requirements="\d+")
     *
     * @Route("/api/order-status", name="order-status", methods={"GET"})
     *
     * @return Response
     * @throws \App\Exception\OrderException
     */
    public function getOrderStatus(ParamFetcher $paramFetcher): Response
    {
        $orderStatusResponse = $this->orderService->getOrderStatus($paramFetcher);

        return new Response($this->serializer->serialize($orderStatusResponse, 'json'));
    }

    /**
     * @param ParamFetcher $paramFetcher
     *
     * @RequestParam(name="order_id", requirements="\d+")
     * @RequestParam(name="amount", requirements="\d+")
     * @RequestParam(name="currency", requirements="[a-z]+", default="USD")
     * @RequestParam(name="card_number", requirements="\d+")
     * @RequestParam(name="card_holder", requirements="[a-z]+")
     * @RequestParam(name="card_exp_month", requirements="\d+")
     * @RequestParam(name="card_exp_year", requirements="\d+")
     * @RequestParam(name="card_cvv", requirements="\d+")
     * @RequestParam(name="card_pin", requirements="\d+")
     * @RequestParam(name="order_description", requirements="^[a-zA-Z0-9_ ]+")
     * @RequestParam(name="customer_email", requirements="[^@]+@[^\.]+\..+")
     * @RequestParam(name="ip_address", requirements="\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}")
     * @RequestParam(name="platform", requirements="[A-z]+")
     * @RequestParam(name="geo_country", requirements="[A-z]+")
     *
     * @Route("/api/charge", name="charge")
     *
     * @return Response
     */
    public function getCharge(ParamFetcher $paramFetcher): Response
    {
        $response = $this->orderService->proceedCharge($paramFetcher);

        return new Response($this->serializer->serialize($response, 'json'));
    }
}