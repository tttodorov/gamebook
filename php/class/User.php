<?php

// main user class
class User extends BaseObject {

    public $username;
    public $password;
    public $email;
    public $givenname;
    public $photo;
    public $rank;
    public $roles;
    public $clubs;
    public $games;

    public function getClubs()
    {
        return $this->clubs;
    }

    public function setClubs($clubs)
    {
        $this->clubs = $clubs;
        return $this;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    public function getGames()
    {
        return $this->games;
    }

    public function setGames($games)
    {
        $this->games = $games;
        return $this;
    }

    public function getGivenname()
    {
        return $this->givenname;
    }

    public function setGivenname($givenname)
    {
        $this->givenname = $givenname;
        return $this;
    }

    public function getPhoto()
    {
        return $this->photo;
    }

    public function setPhoto($photo)
    {
        $this->photo = $photo;
        return $this;
    }

    public function getRank()
    {
        return $this->rank;
    }

    public function setRank($rank)
    {
        $this->rank = $rank;
        return $this;
    }

    public function getRoles()
    {
        return $this->roles;
    }

    public function setRoles($roles)
    {
        $this->roles = $roles;
        return $this;
    }

    function __construct() {
        parent::__construct();
    }
    
    public function setUsername($username) {
        $this->username = $username;
        return $this;
    }

    public function getUsername() {
        return $this->username;
    }

    public function setPassword($password) {
        $this->password = $password;
        return $this;
    }

    public function getPassword() {
        return $this->password;
    }

}

?>