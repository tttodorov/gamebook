<?php

/*
 * Copyright 2014 tttodorov.
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

function exception_error_handler($errno, $errstr, $errfile, $errline) {
    throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
}

set_error_handler("exception_error_handler");

// logout
function logout() {
    if (!isset($_SESSION)) {
        session_start();
    }

    // ensures anything dumped out will be caught
    ob_start();

    // destroy all session vars
    session_destroy();

    // clear out the output buffer
    while (ob_get_status()) {
        ob_end_clean();
    }

    // redirected to url
    header('Location: ' . ROOT_DIR);

    // end sripting
    die();
}

// page select
function select_page($page) {
    $pagePathFunction = './functions/pages/' . $page . '.php';
    $pagePath = './pages/' . $page . '.php';

    if (file_exists($pagePath)) {
        if (file_exists($pagePathFunction)) {
            require_once $pagePathFunction;
        }
        require_once $pagePath;
    } else {
        $page = 'home';
    }
}

function loginLdap($username, $password) {
    try {
        $ldapconn = ldap_connect('ds.uni-sofia.bg');
    } catch (Exception $ex) {
        $error = new Error($ex->getMessage());
        $error->writeLog();
        return FALSE;
    }
    if ($ldapconn) {
        $user_dn = "uid=$username,ou=People,dc=uni-sofia,dc=bg";
        try {
            if (ldap_bind($ldapconn, $user_dn, $password)) {
                $user = new UserFunction();
                $user->setUsername($username);
                $user->setPassword($password);
                $user->setInDb();
                $_SESSION['userId'] = intval($user->getId());
                return TRUE;
            }
        } catch (Exception $ex) {
            $error = new Error($ex->getMessage());
            $error->writeLog();
        }
    }
    return FALSE;
}

function getSuapiData($username) {
    global $dbSuApi;
    $query = $dbSuApi->prepare("select PersonData.LDAPUserName as UserName, 
                        Students.Student_ID as Student_ID,
                        PersonData.PersonData_ID as PersonData_ID,
		                CASE WHEN  CHARINDEX(' ', (FullName))>0
                        THEN
                        RTRIM(LTRIM( SUBSTRING(FullName, 1, CHARINDEX(' ', FullName))))
                        ELSE '' 
                        END AS FirstName,
                        CASE  WHEN (CHARINDEX(' ', FullName)+CHARINDEX(' ',LTRIM(SUBSTRING(FullName, CHARINDEX(' ', FullName),  Len(FullName)))))>0
                        THEN
                        RTRIM(LTRIM( SUBSTRING(FullName, CHARINDEX(' ', LTRIM(FullName)) , CHARINDEX(' ',LTRIM(SUBSTRING(FullName, CHARINDEX(' ', FullName),  Len(FullName)))))))
                        ELSE '' 
                        END AS SecondName,
                        RTRIM(LTRIM( SUBSTRING(LTRIM(FullName), CHARINDEX(' ', LTRIM(FullName)) + CHARINDEX(' ',SUBSTRING(LTRIM(FullName), CHARINDEX(' ',  LTRIM(FullName))+1,  Len(FullName) ) ), Len(FullName))))
                        AS LastName,
		                Countries.CountryName as CountryName,
		                PersonData.PersonalNumber as PersonalNumber,
		                PersonData.BirthDate as BirthDate,
		                Categories.Category_ID as FacultyID,
						Categories.CategoryName as FacultyName,
		                (SELECT ISNULL(max(Categories.CategoryName), 0) FROM Categories 
						INNER JOIN StudentsCategories ON StudentsCategories.Category_ID = Categories.Category_ID and Categories.CategoryType_ID in (7) AND StudentsCategories.Student_ID = Students.Student_ID
						) AS Course,
					    (SELECT ISNULL(max(Categories.CategoryName), 0) FROM Categories 
						INNER JOIN StudentsCategories ON StudentsCategories.Category_ID = Categories.Category_ID and Categories.CategoryType_ID in (8) AND StudentsCategories.Student_ID = Students.Student_ID
						) AS Groupe,
					    Students.FacultyNumber as FacultyNumber,
						EducationPlans.[BeginYear] as BeginYear,
		                EducationPlans.EducationPlanName as EducationPlanName,
		                EducationPlans.EducationPlan_ID as EducationPlanID ,
		                (select ISNULL(max(Number),0)  from EducationalPlanSemesters where EducationalPlanSemesters.EducationPlan_ID = Students.EducationPlan_ID) as CountSemesters,
		                EducationalForms.EducationalForm_ID as EducationalFormID,
						EducationalForms.EducationalFormName as EducationalFormName,
						EducationalDegrees.EducationalDegree_ID as EducationalDegreeID,
		                EducationalDegrees.EducationalDegreeName as EducationalDegreeName,
		                Students.EducationFinanceType_ID as EducationFinanceType_ID
	                from Students
		                Inner Join PersonData ON Students.PersonData_ID = PersonData.PersonData_ID
		                Inner Join Countries ON PersonData.Country_ID = Countries.Country_ID
		                Inner Join StudentsCategories ON Students.Student_ID = StudentsCategories.Student_ID
		                Inner Join Categories ON StudentsCategories.Category_ID = Categories.Category_ID and Categories.CategoryType_ID in (2)
		                Inner Join EducationPlans ON Students.EducationPlan_ID = EducationPlans.EducationPlan_ID
		                Inner Join EducationalDegrees ON EducationPlans.EducationalDegree_ID = EducationalDegrees.EducationalDegree_ID
						Inner Join EducationalForms  ON EducationalForms.EducationalForm_ID=EducationPlans.EducationalForm_ID 
						WHERE PersonData.LDAPUserName = ?");
    try {
        $query->execute(array($username));
        $allRows = $query->fetchAll(PDO::FETCH_ASSOC);
        return $allRows;
    } catch (Exception $exc) {
        $error = new Error($exc->getMessage());
        $error->writeLog();
        return NULL;
    }
}

function getJson($allRows) {
    $json = array();
    $index = 0;
    foreach ($allRows as $row) {
        $json[$index] = [
            'BeginYear' => $row["BeginYear"],
            'BirthDate' => $row["BirthDate"],
            'CountryName' => iconv("WINDOWS-1251", "UTF-8", $row["CountryName"]),
            'CountSemesters' => $row["CountSemesters"],
            'Course' => $row["Course"],
            'CourseID' => isset($row["CourseID"]),
            'EducationalDegreeID' => $row["EducationalDegreeID"],
            'EducationalDegreeName' => iconv("WINDOWS-1251", "UTF-8", $row["EducationalDegreeName"]),
            'EducationalFormID' => $row["EducationalFormID"],
            'EducationalFormName' => iconv("WINDOWS-1251", "UTF-8", $row["EducationalFormName"]),
            'EducationFinanceType_ID' => $row["EducationFinanceType_ID"],
            'EducationPlanID' => $row["EducationPlanID"],
            'EducationPlanName' => iconv("WINDOWS-1251", "UTF-8", $row["EducationPlanName"]),
            'FacultyID' => $row["FacultyID"],
            'FacultyName' => iconv("WINDOWS-1251", "UTF-8", $row["FacultyName"]),
            'FacultyNumber' => $row["FacultyNumber"],
            'FirstName' => iconv("WINDOWS-1251", "UTF-8", $row["FirstName"]),
            'Groupe' => iconv("WINDOWS-1251", "UTF-8", $row["Groupe"]),
            'GroupeID' => isset($row["GroupeID"]),
            'LastName' => iconv("WINDOWS-1251", "UTF-8", $row["LastName"]),
            'PersonalNumber' => $row["PersonalNumber"],
            'PersonData_ID' => $row["PersonData_ID"],
            'RealDisciplineId' => isset($row["RealDisciplineId"]),
            'SecondName' => iconv("WINDOWS-1251", "UTF-8", $row["SecondName"]),
            'Student_ID' => $row["Student_ID"],
            'UserName' => $row["UserName"]
        ];
        $index++;
    }
    return $json;
}

function getFacultyName($facultySusiId) {
    global $dbSusi;
    
    $sql = "";
}