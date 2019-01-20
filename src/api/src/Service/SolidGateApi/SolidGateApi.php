<?php

declare(strict_types=1);

/**
 * Created by PhpStorm.
 * User: dmytro
 * Date: 20.01.19
 * Time: 15:05
 */

namespace App\Service\SolidGateApi;

use Signedpay\API\Api;

class SolidGateApi extends Api
{
    /**
     * SolidGateApi constructor.
     * @param string $merchantId
     * @param string $privateKey
     * @param string $baseUri
     */
    public function __construct(string $merchantId, string $privateKey, string $baseUri)
    {
        parent::__construct($merchantId, $privateKey, $baseUri);
    }
}