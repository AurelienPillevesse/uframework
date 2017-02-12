<?php

use Model\Finder\UserFinder;
use Dal\Connection;
use Model\User;

class UserFinderTest extends TestCase
{
    private $con;
    private $finder;
    public function setUp() {
      $options = [
          PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
          PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
          PDO::ATTR_EMULATE_PREPARES => false,
      ];
        
        $this->con = new Connection("sqlite::memory:", "", "", $options);
        $this->con->exec(<<<SQL        
        CREATE TABLE IF NOT EXISTS USER (
            ID      INT(6)       		NOT NULL,
            LOGIN	VARCHAR(250)		NOT NULL,
            HASH	VARCHAR(250)		NOT NULL,
        );

        INSERT INTO `USER` (`ID`, `LOGIN`, `HASH`) VALUES
        (1, 'UnitTestUser', 'PasswordTest');
        SQL);
        $this->finder = new UserFinder($this->con);
    }

    public function testFindOneByLoginCount()
    {
        $user = $this->finder->findOneByLogin('UnitTestUser');
        $this->assertEquals(1, count($user));
    }

    public function testFindOneByLogin()
    {
        $expected = new User('UnitTestUser', 'password', null, 1);
        $user = $this->finder->findOneByLogin('UnitTestUser');
        $this->assertEquals($expected, $user);
    }
}
