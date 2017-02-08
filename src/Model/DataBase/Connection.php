<?php

namespace Model\DataBase;

use PDO;

class Connection extends PDO {

    private $DSN = '';
    private $Server = '';
    private $DBname = '';
    private $User = '';
    private $Password = '';
    public $db = '';
    private $stmt = '';

    public function __construct($server = 'localhost', $dbname = 'phpbdd', $user = 'root', $password = 'toor') {
        //Assignation des attributs
        $this->DBname = $dbname;
        $this->User = $user;
        $this->Password = $password;
        $this->Server = $server;
        $this->DSN = 'mysql:host=' . $this->Server . ';dbname=' . $this->DBname . '';

        parent::__construct($this->DSN, $this->User, $this->Password);
        $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $this->db;
    }

    public function executeQuery($query, array $parameter = []) {
        $this->stmt = parent::prepare($query);
        foreach ($parameter as $name => $value) {
            $this->stmt->bindValue($name, $value[0], $value[1]);
        }
        return $this->stmt->execute();
    }

    public function getResults() {
        return $this->stmt->fetchall();
    }

    public function destroyQueryResults()
    {
        $this->statement->closeCursor();
        $this->statement = null;
    }

}

?>