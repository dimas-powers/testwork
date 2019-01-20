<?php

declare(strict_types=1);

/**
 * Created by PhpStorm.
 * User: dmytro
 * Date: 20.01.19
 * Time: 20:39
 */

namespace App\Repository\Customer;

use App\Entity\Customer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class CustomerRepository extends ServiceEntityRepository
{
    /**
     * CustomerRepository constructor.
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Customer::class);
    }
}