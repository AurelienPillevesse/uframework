<?php

namespace Model;

/**
 * USER MODEL CLASS
 */
class User
{
  private $id;
  private $login;
  private $hash;

  function __construct($login, $password = null, $hash = null, $id = null)
  {
    if($password != null) {
      $this->hash = password_hash($password, PASSWORD_DEFAULT);
    }
    if($hash != null) {
      $this->hash = $hash;
    }
    $this->login = $login;

    if($id != null) {
      $this->id = $id;
    }
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

  public function getHash()
  {
    return $this->hash;
  }

  public function verifyPassword($password)
  {
    return password_verify($password, $this->hash);
  }
}
