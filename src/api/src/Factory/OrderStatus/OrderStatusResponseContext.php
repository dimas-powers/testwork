<?php
declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: Dmitriy Ivanenko
 * Date: 22.01.19
 * Time: 11:57
 */

namespace App\Factory\OrderStatus;

class OrderStatusResponseContext implements OrderStatusResponseContextInterface
{
    /**
     * @var string
     */
    private $status;

    /**
     * @var string
     */
    private $token;

    public function __construct(array $response)
    {
        var_dump($response['transactions']['card']['card_token']['token']);die();
        if (isset($response['order']['status'])) {
            $this->status = $response['order']['status'];
        } elseif (isset($response['card']['token'])) {
            $this->token = $response['card']['token'];
        }
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    /**
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * @param string $token
     */
    public function setToken(string $token): void
    {
        $this->token = $token;
    }
}