<?php

namespace App\Controller;

use App\Service\SolidGateApi\SolidGateApi;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Signedpay\API\Api;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

class OrderController extends AbstractFOSRestController
{
    /**
     * @var SolidGateApi
     */
    protected $solidGateApi;

    /**
     * @var SerializerInterface
     */
    protected $serializer;

    public function __construct(SolidGateApi $solidGateApi, SerializerInterface $serializer)
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
            'order_id' => 123,
            'order_description' => 'Notebook',
            'platform' => 'test'
        ];

        $response = $this->solidGateApi->initPayment($credentials);

        return new Response($this->serializer->serialize($response, 'json'));
    }
}