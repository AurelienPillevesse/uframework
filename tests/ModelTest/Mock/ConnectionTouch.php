<?php

class ConnectionTouch extends \Dal\Connection
{
    private $statement;
    
    public function __construct()
    {
    }
    
    public function prepareAndExecuteQuery($query, array $parameters = [])
    {
        $this->statement = $this->prepare($query);
        return $this->statement->execute($parameters);
    }
}
