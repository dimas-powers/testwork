<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Balance;
use App\Entity\Customer;
use App\Entity\Order;
use App\Repository\Balance\BalanceRepository;
use App\Repository\Customer\CustomerRepository;
use App\Repository\Order\OrderRepository;
use App\Service\Order\OrderService;
use App\Service\SolidGateApi\SolidGateApiService;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractFOSRestController
{
    /**
     * @var SolidGateApiService
     */
    protected $solidGateApi;

    /**
     * @var SerializerInterface
     */
    protected $serializer;

    protected $orderService;

    public function __construct(
        SolidGateApiService $solidGateApi,
        SerializerInterface $serializer,
        OrderRepository $rep,
        OrderService $orderService
    )
    {
        $this->solidGateApi = $solidGateApi;
        $this->serializer = $serializer;
        $this->orderService = $orderService;
    }

    /**
     * @Route("/api/test", name="test")
     */
    public function getTest(): Response
    {
        var_dump(2);die();
    }
}