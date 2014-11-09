<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UserStudent
 *
 * @author rintintin
 */
class UserStudent extends UserFunction {

    public $user;
    public $name_first;
    public $name_second;
    public $name_last;
    public $personal_id_number;
    public $address;
    public $phone;
    public $email;
    public $faculty;
    public $degree;
    public $speciality;
    public $faculty_number;
    public $academic_year;
    public $semester_type;
    public $course;
    public $gpa;
    public $gender;
    public $father;
    public $mother;
    public $sibling;
    public $salary;
    public $pension;
    public $child_allowances;
    public $scholarships;
    public $others_incomes;
    public $all_incomes;
    public $family_member_income;
    public $bank;
    public $iban;
    public $accept_university;
    public $accept_regulatory;

    function __construct() {
        parent::__construct();
    }

    function setUser($user) {
        $this->user = 0;
        if (is_int($user)) {
            $this->user = $user;
        }
    }

    function getUser() {
        return $this->user;
    }

    function setNameFirst($name_first) {
        $this->name_first = "";
        if (isset($name_first)) {
            $this->name_first = $name_first;
        }
    }

    function getNameFirst() {
        return $this->name_first;
    }

    function setNameSecond($name_second) {
        $this->name_second = "";
        if (isset($name_second)) {
            $this->name_second = $name_second;
        }
    }

    function getNameSecond() {
        return $this->name_second;
    }

    function setNameLast($name_last) {
        $this->name_last = "";
        if (isset($name_last)) {
            $this->name_last = $name_last;
        }
    }

    function getNameLast() {
        return $this->name_last;
    }

    function setPersonalIdNumber($personal_id_number) {
        $this->personal_id_number = "";
        if (isset($personal_id_number)) {
            $this->personal_id_number = $personal_id_number;
        }
    }

    function getPersonalIdNumber() {
        return $this->personal_id_number;
    }

    function setAddress($address) {
        $this->address = "";
        if (isset($address)) {
            $this->address = $address;
        }
    }

    function getAddress() {
        return $this->address;
    }

    function setPhone($phone) {
        $this->phone = "";
        if (isset($phone)) {
            $this->phone = $phone;
        }
    }

    function getPhone() {
        return $this->phone;
    }

    function setEmail($email) {
        $this->email = "";
        if (isset($email)) {
            $this->email = $email;
        }
    }

    function getEmail() {
        return $this->email;
    }

    function setGender($gender) {
        $this->gender = 0;
        if (($gender == 0) || ($gender == 1)) {
            $this->gender = $gender;
        }
    }

    function getGender() {
        return $this->gender;
    }

    function setFather($father) {
        $this->father = "";
        if (isset($father)) {
            $this->father = $father;
        }
    }

    function getFather() {
        return $this->father;
    }

    function setMother($mother) {
        $this->mother = "";
        if (isset($mother)) {
            $this->mother = $mother;
        }
    }

    function getMother() {
        return $this->mother;
    }

    function setSibling($sibling) {
        $this->sibling = "";
        if (isset($sibling)) {
            $this->sibling = $sibling;
        }
    }

    function getSibling() {
        return $this->sibling;
    }

    function setFaculty($faculty) {
        $this->faculty = 0;
        if (is_int($faculty)) {
            $this->faculty = $faculty;
        }
    }

    function getFaculty() {
        return $this->faculty;
    }

    function setDegree($degree) {
        $this->degree = 0;
        if (is_int($degree)) {
            $this->degree = $degree;
        }
    }

    function getDegree() {
        return $this->degree;
    }

    function setSpeciality($speciality) {
        $this->speciality = 0;
        if (is_int($speciality)) {
            $this->speciality = $speciality;
        }
    }

    function getSpeciality() {
        return $this->speciality;
    }

    function setFacultyNumber($faculty_number) {
        $this->faculty_number = "";
        if (isset($faculty_number)) {
            $this->faculty_number = $faculty_number;
        }
    }

    function getFacultyNumber() {
        return $this->faculty_number;
    }

    function setAcademicYear($academic_year) {
        $this->academic_year = "";
        if (isset($academic_year)) {
            $this->academic_year = $academic_year;
        }
    }

    function getAcademicYear() {
        return $this->academic_year;
    }

    function setSemesterType($semester_type) {
        $this->semester_type = 0;
        if (is_int($semester_type)) {
            $this->semester_type = $semester_type;
        }
    }

    function getSemesterType() {
        return $this->semester_type;
    }

    function setCourse($course) {
        $this->course = 0;
        if (is_int($course)) {
            $this->course = $course;
        }
    }

    function getCourse() {
        return $this->course;
    }

    function setGpa($gpa) {
        $this->gpa = 0.00;
        if (is_double($gpa)) {
            $this->gpa = $gpa;
        }
    }

    function getGpa() {
        return $this->gpa;
    }

    function setBank($bank) {
        $this->bank = $bank;
    }

    function getBank() {
        return $this->bank;
    }

    function setIban($iban) {
        $this->iban = $iban;
    }

    function getIban() {
        return $this->iban;
    }

    function setAcceptUniversity($accept_university) {
        $this->accept_university = 1;
        if (($accept_university == 0) || ($accept_university == 1)) {
            $this->accept_university = $accept_university;
        }
    }

    function getAcceptUniversity() {
        return $this->accept_university;
    }

    function setAcceptRegulatory($accept_regulatory) {
        $this->accept_regulatory = 1;
        if (($accept_regulatory == 0) || ($accept_regulatory == 1)) {
            $this->accept_regulatory = $accept_regulatory;
        }
    }

    function getAcceptRegulatory() {
        return $this->accept_regulatory;
    }

    function setSalary($salary) {
        $this->salary = 0;
        if (is_int($salary)) {
            $this->salary = $salary;
        }
    }

    function getSalary() {
        return $this->salary;
    }

    function setPension($pension) {
        if (is_int($pension)) {
            $this->pension = $pension;
        }
        $this->pension = 0;
    }

    function getPension() {
        return $this->pension;
    }

    function setChildAllowances($child_allowances) {
        $this->child_allowances = 0;
        if (is_int($child_allowances)) {
            $this->child_allowances = $child_allowances;
        }
    }

    function getChildAllowances() {
        return $this->child_allowances;
    }

    function setScholarships($scholarships) {
        $this->scholarships = 0;
        if (is_int($scholarships)) {
            $this->scholarships = $scholarships;
        }
    }

    function getScholarships() {
        return $this->scholarships;
    }

    function setOthersIncomes($others_incomes) {
        $this->others_incomes = 0;
        if (is_int($others_incomes)) {
            $this->others_incomes = $others_incomes;
        }
    }

    function getOthersIncomes() {
        return $this->others_incomes;
    }

    function setAllIncomes($all_incomes) {
        $this->all_incomes = 0;
        if (is_int($all_incomes)) {
            $this->all_incomes = $all_incomes;
        }
    }

    function getAllIncomes() {
        return $this->all_incomes;
    }

    function setFamilyMemberIncome($family_member_income) {
        $this->family_member_income = 0;
        if (is_int($family_member_income)) {
            $this->family_member_income = $family_member_income;
        }
    }

    function getFamilyMemberIncome() {
        return $this->family_member_income;
    }
}
