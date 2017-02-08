<?php

namespace Model\DataMapper;

use Dal\Connection;
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
        $query = 'SELECT id FROM Status WHERE id = :id';
        $stmt = $this->con->prepare($query);
        $stmt->execute(['id' => $status->getId()]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if(isset($result['id'])) {
            $query = 'INSERT INTO Status (NAME, DESCRIPTION, CREATED_AT) VALUES(:name, :description, :created_at)';
            $stmt = $this->connection->prepare($query);
            $stmt->execute([
                'name' => $status->getUser(),
                'description' => $status->getContent(),
                'created_at' => $status->getDate()->format('Y-m-d H:i:s'),
                ]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            $status->setId($this->con->LastInsertId());

            return $stmt;
        } else {
            $query = 'UPDATE Status SET name = :name, description = :description WHERE id = :id';
            $stmt = $this->connection->prepare($query);
            $stmt->execute([
                'name' => $status->getUser(),
                'description' => $status->getContent(),
                'id' => $status->getId(),
                ]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
        }
    }

    public function remove(Status $status)
    {
        $query = 'DELETE FROM Status WHERE id = :id';
        $stmt = $this->con->prepare($query);
        $stmt->execute(['id' => $status->getId()]);
        return $stmt;
    }
}