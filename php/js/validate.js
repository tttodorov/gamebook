/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var msgValidate = "";
var msgEmail = "Въведете валиден Email адрес във формат: \"<име>@<домейн>.<разширение>\"<br/>";
var msgPhone = "Въведете валиден телефонен номер<br/>";
var msgGpa = "Въведете стойност за успех<br/>";

function validateEmail() {
    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    var email = document.getElementById("email");
    if (!(re.test(email.value))) {
        msgValidate += msgEmail;
    }
    $(email).css("border-color", "red");
    $(email).css("background", "#CCA3AB");
}

//
//function validatePhone(phone) {
//    var re = /^\d{10}$/;
//    if (!(re.test(phone.value))) {
//        msgValidate += msgPhone;
//    }
//    $(phone).css("border-color", "red");
//    $(phone).css("background", "#CCA3AB");
//}
//
//function validateGpa(gpa) {
//    var re = /^\d*\.?\d+$/;
//    if (!(re.test(gpa.value))) {
//        msgValidate += msgGpa;
//    }
//    $(gpa).css("border-color", "red");
//    $(gpa).css("background", "#CCA3AB");
//}
//
//function validateApplication() {
//    msgValidate = "";
//    var email = document.getElementById("email");
//    var phone = document.getElementById("phone");
//    var gpa = document.getElementById("phone");
//    validateEmail(email);
//    validatePhone(phone);
//    validateGpa(gpa);
//
//    window.scrollTo(0, 240);
//    document.getElementById("msgValidate").innerHTML = msgValidate;
//}