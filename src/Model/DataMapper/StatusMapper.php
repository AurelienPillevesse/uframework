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
        $query = 'SELECT ID FROM STATUS WHERE ID = :id';
        $stmt = $this->con->prepare($query);
        $stmt->execute(['id' => $status->getId()]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        //var_dump($result);
        //die;

        if(!isset($result['id'])) {

            //var_dump('yoo');
            //die;
            $query = 'INSERT INTO STATUS (NAME, DESCRIPTION, CREATED_AT) VALUES(:name, :description, :created_at)';

            return $this->con->executeQuery($query, [
                'name' => $status->getUser(),
                'description' => $status->getContent(),
                'created_at' => $status->getDate()->format('Y-m-d H:i:s'),
                ]);
            /*$stmt = $this->con->prepare($query);
            $stmt->execute([
                'name' => $status->getUser(),
                'description' => $status->getContent(),
                'created_at' => $status->getDate()->format('Y-m-d H:i:s'),
                ]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            var_dump($result);

            $status->setId($this->con->LastInsertId());

            var_dump('ajouté');
            var_dump($status);

            die;*/

            //return $stmt;
        } else {
            $query = 'UPDATE Status SET name = :name, description = :description WHERE id = :id';
            $stmt = $this->con->prepare($query);
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