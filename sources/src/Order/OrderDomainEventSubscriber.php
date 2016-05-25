<?php

namespace HsBremen\WebApi\Order;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class OrderDomainEventSubscriber
 *
 * @package HsBremen\WebApi\Order
 */
class OrderDomainEventSubscriber implements EventSubscriberInterface
{
    /** @var  OrderRepository */
    private $orderRepository;

    /**
     * OrderDomainEventSubscriber constructor.
     *
     * @param OrderRepository $orderRepository
     */
    public function __construct(
      OrderRepository $orderRepository
    ) {
        $this->orderRepository = $orderRepository;
    }


    /** {@inheritdoc} */
    public static function getSubscribedEvents()
    {
        return [
          OrderEvent::GET_DETAILS => ['getOrderDetails', 1024],
        ];
    }

    /**
     * @param \HsBremen\WebApi\Order\OrderEvent $event
     *
     * @throws \HsBremen\WebApi\Database\DatabaseException
     */
    public function getOrderDetails(OrderEvent $event)
    {
        $order = $this->orderRepository->getById($event->getOrderId());
        $event->setOrder($order);
    }
}
