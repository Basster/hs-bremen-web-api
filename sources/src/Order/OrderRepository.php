<?php

namespace HsBremen\WebApi\Order;

use Doctrine\DBAL\Connection;
use HsBremen\WebApi\Database\DatabaseException;
use HsBremen\WebApi\Entity\Order;

class OrderRepository
{
    /** @var  Connection */
    private $connection;

    /**
     * OrderRepository constructor.
     *
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function createTable()
    {
        $sql = <<<EOS
CREATE TABLE IF NOT EXISTS `{$this->getTableName()}` (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    status VARCHAR(255) NOT NULL,
    PRIMARY KEY (id)
)
EOS;

        return $this->connection->exec($sql);
    }

    public function getTableName()
    {
        return 'order';
    }

    public function getById($id)
    {
        $sql = <<<EOS
SELECT o.* 
FROM `{$this->getTableName()}` o
WHERE o.id = :id
EOS;

        $orders = $this->connection->fetchAll($sql, ['id' => $id]);
        if (count($orders) === 0) {
            throw new DatabaseException(
              sprintf('Order with id "%d" not exists!', $id)
            );
        }

        return Order::createFromArray($orders[0]);
    }

    public function getAll()
    {
        $sql = <<<EOS
SELECT o.* 
FROM `{$this->getTableName()}` o
EOS;

        $orders = $this->connection->fetchAll($sql);

        $result = [];

        foreach ($orders as $row) {
            $result[] = Order::createFromArray($row);
        }

        return $result;
    }

    public function save(Order $order)
    {
        $data = $order->jsonSerialize();
        unset($data['id']);

        $this->connection->insert("`{$this->getTableName()}`", $data);
        $order->setId($this->connection->lastInsertId());
    }
}
