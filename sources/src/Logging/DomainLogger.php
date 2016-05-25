<?php

namespace HsBremen\WebApi\Logging;

use HsBremen\WebApi\Order\OrderEvent;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class DomainLogger
 *
 * @package HsBremen\WebApi\Logging
 */
class DomainLogger implements EventSubscriberInterface
{
    /** @var  LoggerInterface */
    private $logger;

    /**
     * DomainLogger constructor.
     *
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
          OrderEvent::GET_DETAILS => ['logGetDetails', -10],
        ];
    }

    /**
     * @param \HsBremen\WebApi\Order\OrderEvent $event
     */
    public function logGetDetails(OrderEvent $event)
    {
        $order   = $event->getOrder();
        $message = sprintf('Order with id %d requested.', $order->getId());
        $this->logger->info($message);
    }
}
