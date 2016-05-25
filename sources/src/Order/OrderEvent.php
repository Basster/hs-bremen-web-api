<?php

namespace HsBremen\WebApi\Order;

use HsBremen\WebApi\Entity\Order;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class OrderEvent
 *
 * @package HsBremen\WebApi\Order
 */
class OrderEvent extends Event
{
    const GET_DETAILS = 'order.get_details';

    /** @var  Order */
    private $order;

    /** @var  int */
    private $orderId;

    /**
     * @return int
     */
    public function getOrderId()
    {
        return $this->orderId;
    }

    /**
     * @param int $orderId
     *
     * @return OrderEvent
     */
    public function setOrderId($orderId)
    {
        $this->orderId = $orderId;

        return $this;
    }

    /**
     * @return \HsBremen\WebApi\Entity\Order
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * @param \HsBremen\WebApi\Entity\Order $order
     */
    public function setOrder(Order $order)
    {
        $this->order = $order;
    }
}
