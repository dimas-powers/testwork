<?php

declare(strict_types=1);

/**
 * Created by PhpStorm.
 * User: dmytro
 * Date: 20.01.19
 * Time: 15:05
 */

namespace App\Service\SolidGateApi;

use App\Service\SolidGateApi\Interfaces\PaymentApiInterface;
use Signedpay\API\Api;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

class SolidGateApiService extends Api implements PaymentApiInterface
{
    /**
     * SolidGateApi constructor.
     * @param string $merchantId
     * @param string $privateKey
     * @param string $baseUri
     */
    public function __construct(string $merchantId, string $privateKey, string $baseUri, SerializerInterface $serializer)
    {
        parent::__construct($merchantId, $privateKey, $baseUri);
        $this->serializer = $serializer;
    }

    /**
     * @var SerializerInterface
     */
    protected $serializer;

    /**
     * @param array $attributes
     * @return Response
     */
    public function initPayment(array $attributes): Response
    {
        return new Response($this->serializer->serialize(parent::initPayment($attributes), 'json'));
    }

    /**
     * @param array $attributes
     * @return Response
     */
    public function charge(array $attributes): Response
    {
        return new Response($this->serializer->serialize(parent::charge($attributes), 'json'));
    }

    /**
     * @param array $attributes
     * @return Response
     */
    public function status(array $attributes): Response
    {
        return new Response($this->serializer->serialize(parent::status($attributes), 'json'));
    }
}