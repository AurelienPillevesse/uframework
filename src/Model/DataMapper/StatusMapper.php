<?php

namespace Model\DataMapper;

class StatusMapper implements DataMapperInterface
{
    private $con;

    public function __construct(Connection $con)
    {
        $this->con = $con;
    }

    public function persist(Status $statis)
    {
        // code to save the banana
    }

    public function remove(Status $status)
    {
        $query = 'DELETE FROM Status WHERE id = :id';
        $stmt = $this->con->prepare($query);
        $stmt->execute(['id' => $status->getId()]);
        return $stmt;
    }
}