<?php

namespace Model\DataMapper;

use Dal\Connection;
use Model\Status;
use \PDO;

class UserMapper implements DataMapperInterface
{
    private $con;

    public function __construct(Connection $con)
    {
        $this->con = $con;
    }

    public function persist($user)
    {
        $request = 'INSERT INTO USER(LOGIN, PASSWORD) VALUES (:login,:password)';
        $this->con->prepareAndExecuteQuery($request, ['login' => $user->getUserName(), 'password' => $user->getUserPassword()]);
    }

    public function remove($id)
    {
        $request = 'DELETE FROM USER WHERE ID=:id';
        $this->con->prepareAndExecuteQuery($request, ['id', $id]);
    }
}
