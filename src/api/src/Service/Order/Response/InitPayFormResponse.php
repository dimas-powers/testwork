<?php
/**
 * Created by PhpStorm.
 * User: dmytro
 * Date: 23.01.19
 * Time: 0:13
 */

namespace App\Service\Order\Response;

class InitPayFormResponse
{
    protected $token;

    /**
     * @return mixed
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param mixed $token
     */
    public function setToken($token): void
    {
        $this->token = $token;
    }
}