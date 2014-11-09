<?php

class Error extends BaseObject {

    private $info;
    private $ip;
    private $time;

    function __construct() {
        parent::__construct();
        $a = func_get_args();
        $i = func_num_args();
        if (method_exists($this, $f = '__construct' . $i)) {
            call_user_func_array(array($this, $f), $a);
        }
    }

    function __construct1($info) {
        $ip = $_SERVER['REMOTE_ADDR'];
        $time = date("Y-m-d H:i:s");
        $this->setInfo($info);
        $this->setIp($ip);
        $this->setTime($time);
    }

    function __construct2($info, $ip) {
        $time = date("Y-m-d H:i:s");
        $this->setInfo($info);
        $this->setIp($ip);
        $this->setTime($time);
    }

    function __construct3($info, $ip, $time) {
        $this->setInfo($info);
        $this->setIp($ip);
        $this->setTime($time);
    }

    // object constructor
    function getFromDb($id) {
        //include connection variable
        global $db;

        // sql statement
        $sql = "SELECT *
                FROM log_error
                WHERE is_active='1' AND id='$id'";

        $info_data = array();
        foreach ($db->query($sql) as $key => $value) {
            $info_data[$key] = $value;
        }

        if (isset($info_data[0])) {
            $this->setId($info_data[0]['id']);
            $this->setIsActive($info_data[0]['is_active']);
            $this->setCreatedOn($info_data[0]['created_on']);
            $this->setLastEditedOn($info_data[0]['last_edited_on']);
            $this->setInfo($info_data[0]['info']);
            $this->setIp($info_data[0]['ip']);
            $this->setTime($info_data[0]['time']);
        } else {
            unset($this);
        }
    }

    // store in db function
    function storeInDb() {
        //include connection variable
        global $db;

        // sql statement
        $sql = "INSERT INTO log_error
                (is_active, created_on, last_edited_on,
                info, ip, time)
                VALUES ('" . $this->getIsActive() . "',
                        '" . $this->getCreatedOn() . "',
                        '" . $this->getLastEditedOn() . "',
                        '" . $this->getInfo() . "',
                        '" . $this->getIp() . "',
                        '" . $this->getTime() . "');";

        try {
            $db->exec($sql);
        } catch (Exception $ex) {
            print_r($ex->getMessage());
            die();
        }
    }

    // update in db function
    function updateInDb() {
        //include connection variable
        global $db;

        // sql statement
        $sql = "UPDATE log_error
                SET is_active = '" . $this->getIsActive() . "',
                    last_edited_on = '" . $this->getLastEditedOn() . "',
                    info = '" . $this->getInfo() . "',
                    ip = '" . $this->getIp() . "',
                    time = '" . $this->getTime() . "'
                WHERE id = '" . $this->getId() . "';";

        $db->exec($sql);
    }

    // store in db function
    function writeLog() {
        $date = date("Y-m-d");

        $filename = ROOT_DIR . 'log/log_error' . $date;

        if (!file_exists($filename)) {
            $fp = fopen($filename, "wa");
            fclose($fp);
        }

        $data = date("Y-m-d H:i:s") . " " .
                $this->getIp() . " " .
                $this->getInfo() . PHP_EOL;

        try {
            file_put_contents($filename, $data, FILE_APPEND | LOCK_EX);
        } catch (Exception $ex) {
            print_r("<pre>");
            print_r($ex->getMessage());
            print_r($ex->getTrace());
            print_r("</pre>");
            die();
        }
    }

    
    public function setInfo($info) {
        $this->info = addcslashes($info, "'");
        return $this;
    }

    public function getInfo() {
        return $this->info;
    }

    public function setIp($ip) {
        $this->ip = $ip;
        return $this;
    }

    public function getIp() {
        return $this->ip;
    }

    public function setTime($time) {
        $this->time = $time;
        return $this;
    }

    public function getTime() {
        return $this->time;
    }

}
