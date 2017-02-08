<?php

namespace Model\Finder;

use Exception\HttpException;
use Dal\Connection;
use \PDO;

class StatusFinder implements FinderInterface
{
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function findAll()
    {
        $query = 'SELECT * FROM STATUS';

        $stmt = $this->connection->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        //var_dump($result);
        //if(!empty($results)) {
            //todo
        //}

        return $result;
    }

    public function findOneById($id)
    {
        $query = 'SELECT * FROM STATUS WHERE id = :id';

        $stmt = $this->connection->prepare($query);
        $stmt->execute(['id' => $id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        //var_dump($result);

        //todo create instances of status
        //throw new HttpException(404, 'Status not found');
        return $result;
    }
}
