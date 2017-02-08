<?php

namespace Model\Finder;

use Exception\HttpException;
use Dal\Connection;
use Model\Status;
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

        for ($i = 0; $i < count($result); $i++) { 
            $statuses[] = new Status($result[$i]['NAME'], $result[$i]['DESCRIPTION'], new \DateTime($result[$i]['CREATED_AT']), $result[$i]['ID']);
        }

        //var_dump($result);
        //if(!empty($results)) {
            //todo
        //}

        return $statuses;
    }

    public function findOneById($id)
    {
        $query = 'SELECT * FROM STATUS WHERE id = :id';

        $stmt = $this->connection->prepare($query);
        $stmt->execute(['id' => $id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        $status = new Status($result['NAME'], $result['DESCRIPTION'], new \DateTime($result['CREATED_AT']), $result['ID']);

        //var_dump($result);

        //todo create instances of status
        //throw new HttpException(404, 'Status not found');
        return $result;
    }
}
