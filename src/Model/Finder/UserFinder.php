<?php

namespace Model\Finder;

use Exception\HttpException;
use Dal\Connection;
use Model\User;
use \PDO;

class UserFinder
{
    private $connection;

    public function __construct(DatabaseConnection $connection)
    {
        $this->connection = $connection;
    }

    public function findOneById($id)
    {
        $request = 'SELECT * FROM USER WHERE ID=:id';
        $this->connection->prepareAndExecuteQuery($request, ['id' => $id]);
        $result = $this->connection->getResult();
        $this->connection->destroyQueryResults();

        return count($result) == 0 ? null : new User($result[0]['ID'], $result[0]['LOGIN'], $result[0]['PASSWORD']);
    }

    public function findOneByLogin($login)
    {
        $request = 'SELECT * FROM USER WHERE LOGIN=:login';
        $this->connection->prepareAndExecuteQuery($request, ['login' => $login]);
        $result = $this->connection->getResult();
        $this->connection->destroyQueryResults();
        return count($result) == 0 ? null : new User($result[0]['ID'], $result[0]['LOGIN'], $result[0]['PASSWORD']);
    }
}
