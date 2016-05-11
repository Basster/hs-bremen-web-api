<?php

namespace HsBremen\WebApi\Tests\Order;

use HsBremen\WebApi\Entity\Order;
use HsBremen\WebApi\Order\OrderRepository;

class OrderRepositoryTest extends \PHPUnit_Framework_TestCase
{
    /** @var \Doctrine\DBAL\Connection|\PHPUnit_Framework_MockObject_MockObject $db */
    private $db;

    /** @var  OrderRepository */
    private $repository;

    public function setUp()
    {
        $this->db = self::getMockBuilder('Doctrine\DBAL\Connection')
                        ->disableOriginalConstructor()
                        ->getMock()
        ;

        $this->repository = new OrderRepository($this->db);
    }

    /**
     * @test
     */
    public function shouldReturnTableName()
    {
        self::assertEquals('order', $this->repository->getTableName());
    }

    /**
     * @test
     */
    public function shouldCreateTable()
    {
        $sql = <<<EOS
CREATE TABLE IF NOT EXISTS `order` (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    status VARCHAR(255) NOT NULL,
    PRIMARY KEY (id)
)
EOS;

        $this->db->expects(self::once())
                 ->method('exec')
                 ->with($sql)
        ;

        $this->repository->createTable();
    }

    /**
     * @test
     */
    public function getOrderById()
    {
        $sql   = <<<EOS
SELECT o.* 
FROM `order` o
WHERE o.id = :id
EOS;
        $order = new Order(1);
        $order->setStatus('placed');

        $orders = [
          ['id' => 1, 'status' => 'placed'],
        ];

        $this->db->expects(self::once())
                 ->method('fetchAll')
                 ->with($sql, ['id' => 1])
                 ->willReturn($orders)
        ;

        self::assertEquals($order, $this->repository->getById(1));
    }

    /**
     * @test
     * @expectedException \HsBremen\WebApi\Database\DatabaseException
     * @expectedExceptionMessage Order with id "1" not exists!
     */
    public function orderByIdNotFound()
    {
        $this->db->expects(self::once())
                 ->method('fetchAll')
                 ->willReturn([])
        ;

        $this->repository->getById(1);
    }

    /**
     * @test
     */
    public function getAllOrders()
    {
        $sql   = <<<EOS
SELECT o.* 
FROM `order` o
EOS;
        $order = new Order(1);
        $order->setStatus('placed');

        $orders = [
          ['id' => 1, 'status' => 'placed'],
        ];

        $this->db->expects(self::once())
                 ->method('fetchAll')
                 ->with($sql)
                 ->willReturn($orders)
        ;

        $result = $this->repository->getAll();

        self::assertEquals($order, $result[0]);
    }

    /**
     * @test
     */
    public function insertAnOrder()
    {
        $orderData = ['status' => 'placed'];
        $this->db->expects(self::once())
                 ->method('insert')
                 ->with('order', $orderData)
        ;

        $this->db->expects(self::once())
                 ->method('lastInsertId')
                 ->willReturn(1)
        ;

        $order = new Order();
        $order->setStatus('placed');

        $this->repository->save($order);

        self::assertEquals(1, $order->getId());
    }
}
