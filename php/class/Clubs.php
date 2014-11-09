<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 14-11-9
 * Time: 13:12
 */

class Club extends BaseObject {

    public $name;
    public $url;
    public $photo;
    public $rank;
    public $players;
    public $games;

    public function getGames()
    {
        return $this->games;
    }

    public function setGames($games)
    {
        $this->games = $games;
        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
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

    public function getPlayers()
    {
        return $this->players;
    }

    public function setPlayers($players)
    {
        $this->players = $players;
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

    public function getUrl()
    {
        return $this->url;
    }

    public function setUrl($url)
    {
        $this->url = $url;
        return $this;
    }

} 