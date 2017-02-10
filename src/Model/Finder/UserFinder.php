<?php

namespace Model\Finder;

use Exception\HttpException;
use Dal\Connection;
use Model\User;
use \PDO;

class UserFinder
{
    private $con;

    public function __construct(Connection $con)
    {
        $this->con = $con;
    }

    public function findOneById($id)
    {
        $request = 'SELECT * FROM USER WHERE ID = :id';
        $stmt = $this->con->prepare($request);
        $stmt->bindValue(':id',$id);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return count($result) == 0 ? null : new User($result['LOGIN'], null, $result['HASH'], $result['ID']);
    }

    public function findOneByLogin($login)
    {
        $request = 'SELECT * FROM USER WHERE LOGIN = :login';
        $stmt = $this->con->prepare($request);
        $stmt->bindValue(':login', $login);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return count($result) == 0 ? null : new User($result['LOGIN'], null, $result['HASH'], $result['ID']);
    }
}
