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


    public function __construct(array $response)
    {
        if (isset($response['order']['status'])) {
            $this->status = $response['order']['status'];
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
}