<?php

namespace Model;

/**
 * USER MODEL CLASS
 */
class User
{
  private $id;
  private $login;
  private $password;

  function __construct($id,$login,$password)
  {
    $this->login = $login;
    $this->password = $password;
  }

  public function getId()
  {
    return $this->id;
  }

  public function setId($id)
  {
      $this->id = $id;
  }

  public function getLogin()
  {
    return $this->login;
  }

  private function getPassword($value='')
  {
    return $this->password;
  }
}
