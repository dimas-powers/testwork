<?php

declare(strict_types=1);

/**
 * Created by PhpStorm.
 * User: Dmitriy Ivanenko
 * Date: 22.01.19
 * Time: 10:45
 */

namespace App\Service\Customer;

use App\Entity\Customer;
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
}