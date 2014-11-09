<?php

/*
 * Copyright 2014 rintintin.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

if ((isset($_POST['username'])) &&
        (isset($_POST['password'])) &&
        (isset($_POST['loginForm']))) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    if ($_POST['loginForm'] == "formLoginSubmitValidate") {
        if (loginLdap($username, $password)) {
            if (getSuapiData($username) != NULL) {
                $allRows = getSuapiData($username);
                $json = getJson($allRows);

                $userStudentSpeciality = $_SESSION['userStudentSpeciality'] = 0;
                
                $userStudent = new UserStudentFunction();
                $userStudent->setUser(intval($_SESSION['userId']));
                $userStudent->getByUser();
                $userStudent->setNameFirst($json[$userStudentSpeciality]['FirstName']);
                $userStudent->setNameSecond($json[$userStudentSpeciality]['SecondName']);
                $userStudent->setNameLast($json[$userStudentSpeciality]['LastName']);
                $userStudent->setPersonalIdNumber($json[$userStudentSpeciality]['PersonalNumber']);
                $userStudent->setFaculty(intval($json[$userStudentSpeciality]['FacultyID']));
                $userStudent->setDegree($json[$userStudentSpeciality]['EducationalDegreeID']);
                $userStudent->setSpeciality($json[$userStudentSpeciality]['EducationPlanID']);
                $userStudent->setFacultyNumber(intval($json[$userStudentSpeciality]['FacultyNumber']));

                $userStudent->setAcademicYear(user_student_university_academic_year_current);
                $userStudent->setInDb();

                $_SESSION["json_obj"] = $json;
                header('Location: ' . ROOT_DIR . "?page=home");
            }
        } else {
            setcookie('msg', login_msg_wrong_data, time() + 1);
            header('Location: ' . ROOT_DIR . "?msg=" . login_msg_wrong_data);
        }
    } else {
        $error = new Error("bot query");
        $error->writeLog();
    }
}
