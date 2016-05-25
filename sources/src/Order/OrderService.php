<?php

namespace HsBremen\WebApi\Order;

use HsBremen\WebApi\Entity\Order;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class OrderService
{
    /** @var  OrderRepository */
    private $orderRepository;

    /** @var  EventDispatcherInterface */
    private $eventDispatcher;

    /**
     * OrderService constructor.
     *
     * @param OrderRepository          $orderRepository
     * @param EventDispatcherInterface $eventDispatcher
     */
    public function __construct(
      OrderRepository $orderRepository,
      EventDispatcherInterface $eventDispatcher
    ) {
        $this->orderRepository = $orderRepository;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * GET /order
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getList()
    {
        return new JsonResponse($this->orderRepository->getAll());
    }

    /**
     * GET /order/{orderId}
     *
     * @param $orderId
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getDetails($orderId)
    {
        $event = new OrderEvent();
        $event->setOrderId($orderId);

        $this->eventDispatcher->dispatch(OrderEvent::GET_DETAILS, $event);

        return new JsonResponse($event->getOrder());
    }

    /**
     * POST /order
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function createOrder(Request $request)
    {
        $postData = $request->request->all();
        unset($postData['id']);

        $order = Order::createFromArray($postData);

        $this->orderRepository->save($order);

        return new JsonResponse($order, 201);
    }

    /**
     * PUT /order/{orderId}
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function changeOrder(Request $request)
    {
        $order = new Order(1);
        $newId = $request->request->get('id', 0);
        $order->setId($newId);

        return new JsonResponse($order);
    }
}
