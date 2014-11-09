<?php

// main user class
class UserStudentFunction extends UserStudent {

    function getByUser() {
        // create user record
        global $db;

        $sqlStudentUserByUser = "SELECT 
                                    `id`,`name_first`,`name_second`,`name_last`,
                                    `personal_id_number`,`address`,`phone`,
                                    `email`,`degree`,`faculty`,
                                    `speciality`,`faculty_number`,`academic_year`,
                                    `semester_type`,`course`,`gpa`,
                                    `gender`,`father`,`mother`,
                                    `sibling`,`salary`,`pension`,
                                    `child_allowances`,`scholarships`,`other_incomes`,
                                    `all_incomes`,`family_member_income`,`bank`,
                                    `iban`,`accept_university`,`accept_regulatory`
                                FROM `users_student`
                                WHERE
                                `is_active`=1 AND user=:user;";
        try {
            $sth = $db->prepare($sqlStudentUserByUser, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            $sth->execute(array(":user" => $this->getUser()));
            $userData = $sth->fetch();
            $this->setId($userData['id']);
            $this->setNameFirst($userData['name_first']);
            $this->setNameSecond($userData['name_second']);
            $this->setNameLast($userData['name_last']);
            $this->setPersonalIdNumber($userData['personal_id_number']);
            $this->setAddress($userData['address']);
            $this->setPhone($userData['phone']);
            $this->setEmail($userData['email']);
            $this->setDegree($userData['degree']);
            $this->setFaculty(intval($userData['faculty']));
            $this->setSpeciality($userData['speciality']);
            $this->setFacultyNumber($userData['faculty_number']);
            $this->setAcademicYear($userData['academic_year']);
            $this->setGender($userData['speciality']);
            $this->setFather($userData['faculty_number']);
            $this->setMother($userData['academic_year']);
            $this->setSibling($userData['academic_year']);
            $this->setSalary($userData['faculty_number']);
            $this->setPension($userData['academic_year']);
            $this->setChildAllowances($userData['academic_year']);
            $this->setCourse($userData['academic_year']);
            $this->setGpa($userData['faculty_number']);
            $this->setScholarships($userData['academic_year']);
            $this->setOthersIncomes($userData['academic_year']);
            $this->setAllIncomes($userData['academic_year']);
            $this->setFamilyMemberIncome($userData['faculty_number']);
            $this->setBank($userData['academic_year']);
            $this->setIban($userData['academic_year']);
            $this->setAcceptUniversity($userData['academic_year']);
            $this->setAcceptRegulatory($userData['academic_year']);
            return $this->getUser();
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

        $sqlUpdateUser = "UPDATE `users` SET 
                                    `last_edited_on`='" . $this->getLastEditedOn() . "',
                                    `last_edited_ip`='" . $this->getLastEditedIp() . "',
                                WHERE `id`='" . $this->getId() . "';";

        try {
            $sth = $db->prepare($sqlUpdateUser);
            $sth->execute();
        } catch (Exception $ex) {
            $error = new Error($ex->getMessage());
            $error->writeLog();
        }

        if (is_null($this->getId())) {
            $this->setCreatedOn(date("Y:m:d H:i:s"));
            $sqlInsertUserStudent = "INSERT INTO `users_student`
                                        (`is_active`,`created_on`,
                                        `last_edited_on`,`user`,
                                        `name_first`,`name_second`,`name_last`,
                                        `personal_id_number`,`address`,`phone`,
                                        `email`,`faculty`,`degree`,
                                        `speciality`,`faculty_number`,`academic_year`,
                                        `semester_type`,`course`,`gpa`,
                                        `gender`,`father`,`mother`,
                                        `sibling`,`salary`,`pension`,
                                        `child_allowances`,`scholarships`,`other_incomes`,
                                        `all_incomes`,`family_member_income`,`bank`,
                                        `iban`,`accept_university`,`accept_regulatory`)
                                    VALUES
                                        ('" . $this->getIsActive() . "',
                                        '" . $this->getCreatedOn() . "',
                                        '" . $this->getLastEditedOn() . "',
                                        '" . $this->getUser() . "',
                                        '" . $this->getNameFirst() . "',
                                        '" . $this->getNameSecond() . "',
                                        '" . $this->getNameLast() . "',
                                        '" . $this->getPersonalIdNumber() . "',
                                        '" . $this->getAddress() . "',
                                        '" . $this->getPhone() . "',
                                        '" . $this->getEmail() . "',
                                        '" . $this->getFaculty() . "',
                                        '" . $this->getDegree() . "',
                                        '" . $this->getSpeciality() . "',
                                        '" . $this->getFacultyNumber() . "',
                                        '" . $this->getAcademicYear() . "',
                                        '" . $this->getSemesterType() . "',
                                        '" . $this->getCourse() . "',
                                        '" . $this->getGpa() . "',
                                        '" . $this->getGender() . "',
                                        '" . $this->getFather() . "',
                                        '" . $this->getMother() . "',
                                        '" . $this->getSibling() . "',
                                        '" . $this->getSalary() . "',
                                        '" . $this->getPension() . "',
                                        '" . $this->getChildAllowances() . "',
                                        '" . $this->getScholarships() . "',
                                        '" . $this->getOthersIncomes() . "',
                                        '" . $this->getAllIncomes() . "',
                                        '" . $this->getFamilyMemberIncome() . "',
                                        '" . $this->getBank() . "',
                                        '" . $this->getIban() . "',
                                        '" . $this->getAcceptUniversity() . "',
                                        '" . $this->getAcceptRegulatory() . "');";

            try {
                $sth = $db->prepare($sqlInsertUserStudent);
                $sth->execute();
            } catch (Exception $ex) {
                $error = new Error($ex->getMessage());
                $error->writeLog();
            }
        } else {
            $sqlUpdateUserStudent = "UPDATE `users_student`
                                    SET 
                                        `last_edited_on`='" . $this->getLastEditedOn() . "',
                                        `name_first`='" . $this->getNameFirst() . "',
                                        `name_second`='" . $this->getNameSecond() . "',
                                        `name_last`='" . $this->getNameLast() . "',
                                        `personal_id_number`='" . $this->getPersonalIdNumber() . "',
                                        `address`='" . $this->getAddress() . "',
                                        `phone`='" . $this->getPhone() . "',
                                        `email`='" . $this->getEmail() . "',
                                        `faculty`='" . $this->getFaculty() . "',
                                        `degree`='" . $this->getDegree() . "',
                                        `speciality`='" . $this->getSpeciality() . "',
                                        `faculty_number`='" . $this->getFacultyNumber() . "',
                                        `academic_year`='" . $this->getAcademicYear() . "',
                                        `semester_type`='" . $this->getSemesterType() . "',
                                        `course`='" . $this->getCourse() . "',
                                        `gpa`='" . $this->getGpa() . "',
                                        `gender`='" . $this->getGender() . "',
                                        `father`='" . $this->getFather() . "',
                                        `mother`='" . $this->getMother() . "',
                                        `sibling`='" . $this->getSibling() . "',
                                        `salary`='" . $this->getSalary() . "',
                                        `pension`='" . $this->getPension() . "',
                                        `child_allowances`='" . $this->getChildAllowances() . "',
                                        `scholarships`='" . $this->getScholarships() . "',
                                        `other_incomes`='" . $this->getOthersIncomes() . "',
                                        `all_incomes`='" . $this->getAllIncomes() . "',
                                        `family_member_income`='" . $this->getFamilyMemberIncome() . "',
                                        `bank`='" . $this->getBank() . "',
                                        `iban`='" . $this->getIban() . "',
                                        `accept_university`='" . $this->getAcceptUniversity() . "',
                                        `accept_regulatory`='" . $this->getAcceptRegulatory() . "'
                                    WHERE `is_active`='1' AND `user`='" . $this->getUser() . "';";

//            echo '<pre>';
//            var_dump($sqlUpdateUserStudent);
//            die();

            try {
                $sth = $db->prepare($sqlUpdateUserStudent);
                $sth->execute();
            } catch (Exception $ex) {
                $error = new Error($ex->getMessage());
                $error->writeLog();
                var_dump($error);
            }
        }
    }

}

?>