<?php

declare(strict_types=1);

/**
 * Created by PhpStorm.
 * User: Dmitriy Ivanenko
 * Date: 22.01.19
 * Time: 10:45
 */

namespace App\Service\Customer;

use App\Entity\Balance;
use App\Entity\Customer;
use App\Service\Order\Response\InitPaymentResponse;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Request\ParamFetcher;

/**
 * Class CustomerService
 * @package App\Service\Customer
 */
class CustomerService
{

    private $entityManager;

    /**
     * CustomerService constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param ParamFetcher $fetcher
     * @return Customer|null
     */
    public function getCustomerByRequestEmail(ParamFetcher $fetcher): ?Customer
    {
        $email = $fetcher->get('customer_email');

        return $this->entityManager->getRepository(Customer::class)->findOneBy(['email' => $email]);
    }

    /**
     * @param Customer $customer
     * @param InitPaymentResponse $initPaymentResponse
     */
    public function setTokenToCustomer(Customer $customer, InitPaymentResponse $initPaymentResponse): void
    {
        $customer->setToken($initPaymentResponse->getToken());

        $this->entityManager->persist($customer);
        $this->entityManager->flush();
    }

    /**
     * @param Customer $customer
     * @param InitPaymentResponse $initPaymentResponse
     */
    public function eraseCredentials(Customer $customer, InitPaymentResponse $initPaymentResponse): void
    {
        $balances = $customer->getBalances();

        /**
         * @var Balance $balance
         */
        foreach ($balances as $balance) {
            if ($balance->getCurrency() === $initPaymentResponse->getCurrency()) {
                $balance->setAmount($balance->getAmount() - $initPaymentResponse->getAmount());
            }
        }

        $this->entityManager->persist($balance);
        $this->entityManager->flush();
    }
}