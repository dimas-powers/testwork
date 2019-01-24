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
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Class SolidGateApiService
 * @package App\Service\SolidGateApi
 */
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
     * @return array
     */
    public function initPayment(array $attributes): array
    {
        return parent::initPayment($attributes);
    }

    /**
     * @param array $attributes
     * @return array
     */
    public function charge(array $attributes): array
    {
        return parent::charge($attributes);
    }

    /**
     * @param array $attributes
     * @return array
     */
    public function status(array $attributes): array
    {
        return parent::status($attributes);
    }

    /**
     * @param array $attributes
     * @return array
     */
    public function recurring(array $attributes): array
    {
        return parent::recurring($attributes);
    }

    /**
     * @param array $attributes
     * @return array
     */
    public function refund(array $attributes): array
    {
        return parent::refund($attributes);
    }
}