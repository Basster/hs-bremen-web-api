<?php


namespace HsBremen\WebApi\Tests\Error;


use HsBremen\WebApi\Database\DatabaseException;
use HsBremen\WebApi\Error\UnhandledExceptionSubscriber;
use Prophecy\Argument;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class UnhandledExceptionSubscriberTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function subscribesKernelExceptionEvent()
    {
        self::assertArrayHasKey(
          KernelEvents::EXCEPTION,
          UnhandledExceptionSubscriber::getSubscribedEvents()
        );
    }

    /**
     * @test
     */
    public function createResponseFromException()
    {
        $exception = new DatabaseException('foobar');

        $subscriber = new UnhandledExceptionSubscriber(false);
        $event      = $this->prophesize(GetResponseForExceptionEvent::class);
        $event->getException()->shouldBeCalled()->willReturn($exception);

        $response = function ($jsonResponse) {
            self::assertInstanceOf(JsonResponse::class, $jsonResponse);
            self::assertContains(
              '"message":"foobar"',
              $jsonResponse->getContent()
            );

            return true;
        };

        $event->setResponse(Argument::that($response))->shouldBeCalled();

        $subscriber->onKernelException($event->reveal());
    }
}
