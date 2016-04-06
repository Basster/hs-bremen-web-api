<?php

namespace HsBremen\WebApi\Entity;

class Order implements \JsonSerializable
{
    private $id;

    public function __construct($id)
    {
        $this->id = $id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    function jsonSerialize()
    {
        return [
          'id'     => $this->id,
          'status' => 'placed',
        ];
    }
}
