<?php

namespace HsBremen\WebApi\Tests\Acceptance;

use HsBremen\WebApi\Application;
use Silex\WebTestCase;
use Symfony\Component\HttpFoundation\JsonResponse;

class OrderWebTest extends WebTestCase
{
    /** {@inheritdoc} */
    public function createApplication()
    {
        $app          = new Application();
        $app['debug'] = true;
        unset($app['exception_handler']);

        return $app;
    }

    /**
     * @test
     */
    public function getDetailRoute()
    {
        $client = $this->createClient();

        $options = [
          'PHP_AUTH_USER' => 'admin',
          'PHP_AUTH_PW'   => 'foo',
          'HTTP_Accept'   => 'application/json',
        ];

        $client->request('GET', '/order/1', [], [], $options);

        $response = $client->getResponse();

        self::assertInstanceOf(JsonResponse::class, $response);

        $responseData = json_decode($response->getContent(), true);

        self::assertEquals(1, $responseData['id']);
        self::assertEquals('placed', $responseData['status']);

    }
}
