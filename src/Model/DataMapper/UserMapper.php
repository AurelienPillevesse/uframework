<?php

namespace Model\DataMapper;

use Dal\Connection;
use Model\Status;
use \PDO;

class UserMapper implements DataMapperInterface
{
    private $connection;

    public function __construct(DatabaseConnection $connection)
    {
        $this->connection = $connection;
    }

    public function persist($user)
    {
        $request = 'INSERT INTO USER(LOGIN, PASSWORD) VALUES (:login,:password)';
        $this->connection->prepareAndExecuteQuery($request, ['login' => $user->getUserName(), 'password' => $user->getUserPassword()]);
    }

    public function remove($id)
    {
        $request = 'DELETE FROM USER WHERE ID=:id';
        $this->connection->prepareAndExecuteQuery($request, ['id', $id]);
    }
}
