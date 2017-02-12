<?php

use Model\Finder\UserFinder;
use Dal\Connection;
use Model\User;

class UserFinderTest extends TestCase
{
    private $con;
    private $finder;
    public function setUp()
      $dsn = 'mysql:host=127.0.0.1;dbname=uframework;port=32768' ;
      $user = 'uframework' ;
      $password = 'p4ssw0rd';
      $options = [
          PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
          PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
          PDO::ATTR_EMULATE_PREPARES => false,
      ];
        $this->con = new Connection($dsn, $user, $password, $options);
        $this->con->exec(<<<SQL
        CREATE TABLE IF NOT EXISTS USER (
        	ID      INT(6)       		NOT NULL AUTO_INCREMENT,
        	LOGIN	VARCHAR(250)		NOT NULL,
        	HASH	VARCHAR(250)		NOT NULL,
        	PRIMARY KEY (ID)
        );

        INSERT INTO `USER` (`ID`, `LOGIN`, `HASH`) VALUES
        (1, 'UnitTestUser', 'PasswordTest'); //HASH PASSWORD
        SQL);
        $this->finder = new UserFinder($this->con);
    }

    public function testFindOneByIdCount()
    {
        $user = $this->finder->findOneById(1);
        $this->assertEquals(1, count($user));
    }

    public function testFindOneById()
    {
        $expected = new User('UnitTestUser', 'password', null,1);
        $user = $this->finder->findOneById(1);
        $this->assertEquals($expected, $user);
    }

    public function testFindOneByUserNameCount()
    {
        $user = $this->finder->findOneByUserName('UnitTestUser');
        $this->assertEquals(1, count($user));
    }

    public function testFindOneByName()
    {
        $expected = new User('UnitTestUser', 'password', null,1);
        $user = $this->finder->findOneByUserName('UnitTestUser');
        $this->assertEquals($expected, $user);
    }
}
