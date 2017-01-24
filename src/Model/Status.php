<?php

namespace Model;

class Status 
{

    private $id;
    private $user;
    private $content;
    private $date;

    public function __construct($id = null, $user = null, $content = null) {
        if($id != null & $user != null & $content != null) {
            $this->setId($id);
            $this->setUser($user);
            $this->setContent($content);
            $this->setDate(new DateTime('NOW'));
        }
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getUser() {
        return $this->user;
    }

    public function setUserId($user) {
        $this->user = $user;
    }

    public function getContent() {
        return $this->content;
    }

    public function setContent($content) {
        $this->content = $content;
    }

    public function getDate() {
        return $this->date;
    }

    public function setDate(DateTime $date) {
        $this->date = $date;
    }
}