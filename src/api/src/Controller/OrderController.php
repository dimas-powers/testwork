<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\SolidGateApi\SolidGateApiService;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Routing\Annotation\Route;

class OrderController extends AbstractFOSRestController
{
    /**
     * @var SolidGateApiService
     */
    protected $solidGateApi;

    /**
     * @var SerializerInterface
     */
    protected $serializer;

    public function __construct(SolidGateApiService $solidGateApi, SerializerInterface $serializer)
    {
        $this->solidGateApi = $solidGateApi;
        $this->serializer = $serializer;
    }

    public function getOrderAction(): Response
    {
        $credentials = [
            'privateKey' => '0795f79f-a045-4901-adf0-05481df6c666',
            'merchantId' => 'unicorn',
            'amount' => 1,
            'currency' => 'USD',
            'customer_email' => 'test@test.com',
            'geo_country' => 'NGR',
            'ip_address' => '178.150.56.130',
            'order_id' => 125,
            'order_description' => 'Premium package',
            'platform' => 'test'
        ];

        $response = $this->solidGateApi->initPayment($credentials);

        return new Response($this->serializer->serialize($response, 'json'));
    }

    /**
     * @Route("/api/charge", name="charge")
     */
    public function getCharge(): Response
    {
        $credentials = [
            'order_id' => 123,
            'amount' => 1,
            'currency' => 'USD',
            'card_number' => 4111111111111111,
            'card_holder' => 'JOHN SNOW',
            'card_exp_month' => 01,
            'card_exp_year' => 2024,
            'card_cvv' => 123,
            'card_pin' => 1111,
            'order_description' => 'Premium package',
            'customer_email' => 'jondou@gmail.com',
            'ip_address' => '8.8.8.8',
            'platform' => 'web',
            'geo_country' => 'GBR'
        ];

        $response = $this->solidGateApi->charge($credentials);

        return new Response($this->serializer->serialize($response, 'json'));
    }

    public function getOrderStatusAction(): Response
    {
        $credentials = [
            'order_id' => 123
        ];

        $response = $this->solidGateApi->status($credentials);

        return new Response($this->serializer->serialize($response, 'json'));
    }
}