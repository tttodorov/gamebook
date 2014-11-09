<?php

// main user class
class UserFunction extends User {

    function getUserIdByUsername() {
        // create user record
        global $db;

        $sqlLastUser = "SELECT id 
                        FROM `users`
                        WHERE
                        `is_active`=1 AND username=:username;";
        try {
            $sth = $db->prepare($sqlLastUser, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            $sth->execute(array(":username" => $this->getUsername()));
            $userData = $sth->fetch();
            return $userData['id'];
        } catch (Exception $ex) {
            $error = new Error($ex->getMessage());
            $error->writeLog();
        }
        return NULL;
    }

    function setInDb() {
        global $db;

        $this->setLastEditedOn(date("Y:m:d H:i:s"));
        $this->setLastEditedIp(date($_SERVER['REMOTE_ADDR']));

        $this->setId($this->getUserIdByUsername());

        if (is_null($this->getId())) {
            $this->setCreatedOn(date("Y:m:d H:i:s"));
            $this->setCreatedIp(date($_SERVER['REMOTE_ADDR']));
            $sqlInsertUser = "INSERT INTO `users`
                                (`is_active`, 
                                `created_on`, 
                                `last_edited_on`, 
                                `created_ip`, 
                                `last_edited_ip`, 
                                `username`, 
                                `password`) 
                                VALUES 
                                (   '" . $this->getIsActive() . "',
                                    '" . $this->getCreatedOn() . "',
                                    '" . $this->getLastEditedOn() . "',
                                    '" . $this->getCreatedIp() . "',
                                    '" . $this->getLastEditedIp() . "',
                                    '" . $this->getUsername() . "',
                                    '" . md5($this->getPassword()) . "');";
            try {
                $sth = $db->prepare($sqlInsertUser);
                $sth->execute();
            } catch (Exception $ex) {
                $error = new Error($ex->getMessage());
                $error->writeLog();
            }
        } else {
            $sqlUpdateUser =    "UPDATE `users`
                                SET `last_edited_on`='" . $this->getLastEditedOn() . "',
                                    `last_edited_ip`='" . $this->getLastEditedIp() . "',
                                    `password`='" . md5($this->getPassword()) . "'
                                WHERE id='" . $this->getId() . "';";
            try {
                $sth = $db->prepare($sqlUpdateUser);
                $sth->execute();
            } catch (Exception $ex) {
                $error = new Error($ex->getMessage());
                $error->writeLog();
                var_dump($error);
            }
        }
    }

    function getFromDb() {
        global $db;
        if (is_null($this->getId())) {
            $sqlSelectUser = "SELECT
                                    `created_on`, 
                                    `last_edited_on`, 
                                    `created_ip`, 
                                    `last_edited_ip`, 
                                    `username`
                                FROM `users`
                                WHERE id=" . $this->getId() . "";
            try {
                $sth = $db->prepare($sqlSelectUser);
                $sth->execute();
                $userData = $sth->fetch();
                $this->setCreatedOn($userData['created_on']);
                $this->setCreatedIp($userData['create_ip']);
                $this->setLastEditedOn($userData['last_edited_on']);
                $this->setLastEditedIp($userData['last_edited_ip']);
                $this->setUsername($userData['username']);
            } catch (Exception $ex) {
                $error = new Error($ex->getMessage());
                $error->writeLog();
            }
        } else {
            return NULL;
        }
    }

}

?>