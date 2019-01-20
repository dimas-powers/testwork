<?php
/**
 * Created by PhpStorm.
 * User: dmytro
 * Date: 20.01.19
 * Time: 20:41
 */

declare(strict_types=1);

namespace App\Repository\Order;

use App\Entity\Order;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class OrderRepository extends ServiceEntityRepository
{
    /**
     * OrderRepository constructor.
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Order::class);
    }
}