<?php

namespace HsBremen\WebApi\Order;

use HsBremen\WebApi\Entity\Order;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class OrderService
{
    /**
     * GET /
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getList()
    {
        $orders = [
          new Order(2),
          new Order(3),
        ];
        return new JsonResponse($orders);
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
        return new JsonResponse(new Order($orderId));
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
        return new JsonResponse(new Order($request->request->get('id', 0)),
          201);
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
