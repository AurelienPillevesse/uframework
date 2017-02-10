<?php

namespace Model\DataMapper;

use Dal\Connection;
use Model\Status;
use \PDO;

class StatusMapper
{
    private $con;

    public function __construct(Connection $con)
    {
        $this->con = $con;
    }

    public function persist(Status $status)
    {
        $query = 'INSERT INTO STATUS (NAME, DESCRIPTION, CREATED_AT) VALUES(:name, :description, :created_at)';
        return $this->con->executeQuery($query, [
            'name' => $status->getUser(),
            'description' => $status->getContent(),
            'created_at' => $status->getDate()->format('Y-m-d H:i:s'),
            ]);
    }

    public function remove($id)
    {
        $query = 'DELETE FROM STATUS WHERE ID = :id';
        return $this->con->executeQuery($query,['id' => $id]);
    }
}
