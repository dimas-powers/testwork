<?php

declare(strict_types=1);

/**
 * Created by PhpStorm.
 * User: dmytro
 * Date: 20.01.19
 * Time: 20:37
 */

namespace App\Repository\Balance;

use App\Entity\Balance;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * Class BalanceRepository
 * @package App\Repository\Balance
 */
class BalanceRepository extends ServiceEntityRepository
{
    /**
     * BalanceRepository constructor.
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Balance::class);
    }
}