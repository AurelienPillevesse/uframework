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

    public function findAll($filter = null)
    {
        $query = 'SELECT * FROM STATUS';

        //var_dump($filter);
        /*for ($i = 0; $i < count($filter); $i++) {
            var_dump($filter['order']);
        }*/

        $filterKeys = array_keys($filter);

        for ($i = 0; $i < count($filterKeys); $i++) {
            $currentKey = $filterKeys[$i];
            $currentValue = $filter[$currentKey];

            if($currentValue != '') {
                $currentKey = preg_replace('/[A-Z]/', ' $0', $currentKey);
                $addToQuery = strtoupper($currentKey) . ' ' . $currentValue;

                $query .= ' '.$addToQuery;
            }
        }

        $stmt = $this->connection->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $statuses = [];
        for ($i = 0; $i < count($result); $i++) {
            if($result[$i]['NAME']) {
                $statuses[] = new Status($result[$i]['NAME'], $result[$i]['DESCRIPTION'], new \DateTime($result[$i]['CREATED_AT']), $result[$i]['ID']);
            } else {
                $statuses[] = new Status('Anonymous', $result[$i]['DESCRIPTION'], new \DateTime($result[$i]['CREATED_AT']), $result[$i]['ID']);
            }
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
        return $status;
    }
}
