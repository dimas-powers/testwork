<?php
declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: Dmitriy Ivanenko
 * Date: 22.01.19
 * Time: 12:01
 */

namespace App\Factory\Order;

use App\Entity\Order;
use Doctrine\ORM\EntityManagerInterface;

class OrderFactory implements OrderFactoryInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function create(OrderContextInterface $context): Order
    {
        $order = new Order();
        $order->setAmount($context->getAmount());
        $order->setCurrency($context->getCurrency());
        $order->setCustomer($context->getCustomer());
        $order->setDescription($context->getOrderDescription());
        $order->setGeoCountry($context->getGeoCountry());
        $order->setIpAddress($context->getIpAddress());
        $order->setPlatform($context->getPlatform());

        $this->entityManager->persist($order);
        $this->entityManager->flush();

        return $order;
    }
}