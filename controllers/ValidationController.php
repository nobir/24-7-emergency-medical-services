<?php

require_once dirname(__FILE__, 2) . '/helper/functions.php';


/**
 * 
 * Validation Controller
 * 
 */

function validate_input($str)
{
    return htmlspecialchars(trim($str));
}

function _validate_name(&$name, &$_name, &$messages, &$has_err)
{
    if (empty($_name)) {
        $messages["errors"]['name'] = "Name is required";
        $has_err = true;
    } else if (strlen($_name) < 2) {
        $messages["errors"]['name'] = "Name must be greater than 2 character";
        $has_err = true;
    } else if (preg_match("/^[a-zA-Z-.]/", $_name) != 1) {
        $messages["errors"]['name'] = "Name must be contains alpha character, (.) and (-)";
        $has_err = true;
    } else {
        $name = validate_input($_name);
        $messages['data']['name'] = $name;
    }
}

function _validate_email(&$email, &$_email, &$messages, &$has_err)
{
    if (empty($_email)) {
        $messages["errors"]['email'] = "Email is required";
        $has_err = true;
    } else if (!filter_var($_email, FILTER_VALIDATE_EMAIL)) {
        $messages["errors"]['email'] = "Email is not valid";
        $has_err = true;
    } else {
        $email = validate_input($_email);
        $messages['data']['email'] = $email;
    }
}

/**
 * Regular Expression
 * 
 * @see https://regexr.com/69opj
 */

function _validate_phone(&$phone, &$_phone, &$messages, &$has_err)
{
    if (empty($_phone)) {
        $messages["errors"]['phone'] = "Phone is required";
        $has_err = true;
    } else if (preg_match("/^(\+88)?01[2-9]{1}[0-9]{8}$/", $_phone) != 1) {
        $messages["errors"]['phone'] = "Invalid Phone! valid is +8801234567890, 01234567890";
        $has_err = true;
    } else {
        $phone = validate_input($_phone);
        $messages['data']['phone'] = $phone;
    }
}

function _validate_password(&$password, &$_password, &$messages, &$has_err)
{
    if (empty($_password)) {
        $messages["errors"]['password'] = "Password is required";
        $has_err = true;
    } else if (strlen($_password) < 8) {
        $messages["errors"]['password'] = "Password must be 8 characters or greater";
        $has_err = true;
    } else if (!preg_match("/[@#$%]+/", $_password)) {
        $messages["errors"]['password'] = "Password must include special characters (@ # $ %)";
        $has_err = true;
    } else {
        // $password = password_hash($_password, PASSWORD_DEFAULT);
        $password = $_password;
        $messages['data']['password'] = $password;
    }
}

function _validate_cpassword(&$cpassword, &$_cpassword, &$_password, &$messages, &$has_err)
{
    if (empty($_cpassword)) {
        $messages["errors"]['cpassword'] = "Confirm Password is required";
        $has_err = true;
    } else if ($_cpassword !== $_password) {
        $messages["errors"]['cpassword'] = "Confirm Password must equal to Password";
        $has_err = true;
    } else {
        // $cpassword = password_hash($_cpassword, PASSWORD_DEFAULT);
        $cpassword = $_cpassword;
        $messages['data']['cpassword'] = $cpassword;
    }
}

function _validate_gender(&$gender, &$_gender, &$messages, &$has_err)
{
    if (empty($_gender)) {
        $messages["errors"]['gender'] = "Gender is required";
        $has_err = true;
    } else if (preg_match("/(male|female|other)/", $_gender) != 1) {
        $messages["errors"]['gender'] = "Gender is invalid";
        $has_err = true;
    } else {
        $gender = validate_input($_gender);
        $messages['data']['gender'] = $gender;
    }
}

function _validate_dob(&$dob, &$_dob, &$messages, &$has_err)
{
    if (isset($_dob) && empty($_dob)) {
        $messages["errors"]['dob'] = "Date of birth is required";
        $has_err = true;
    } else if (preg_match("/^\d{4}-\d{2}-\d{2}$/", $_dob) != 1) {
        $messages["errors"]['dob'] = "Date of birth is not valid";
        $has_err = true;
    } else {
        $dob = validate_input($_dob);
        $messages['data']['dob'] = $dob;
    }
}

function _validate_degree(&$degree, &$_degree, &$messages, &$has_err)
{
    if (preg_match("/^[\w_\-\.\s,\:]*$/", $_degree) != 1) {
        $messages["errors"]['degree'] = "Degree must be alphanumaric and can be include (space, : , - _ #)";
        $has_err = true;
    } else {
        $degree = validate_input($_degree);
        $messages['data']['degree'] = $degree;
    }
}

function _validate_specialization(&$specialization, &$_specialization, &$messages, &$has_err)
{
    if (preg_match("/^[\w_\-\.\s,\:]*$/", $_specialization) != 1) {
        $messages["errors"]['specialization'] = "Specialization must be alphanumaric and can be include (space, : , - _ #)";
        $has_err = true;
    } else {
        $specialization = validate_input($_specialization);
        $messages['data']['specialization'] = $specialization;
    }
}

function _validate_schedule(&$schedule, &$_schedule, &$messages, &$has_err)
{
    if (preg_match("/^[\w_\-\.\s,\:]*$/", $_schedule) != 1) {
        $messages["errors"]['schedule'] = "schedule must be alphanumaric and can be include (space, : , - _ #)";
        $has_err = true;
    } else {
        $schedule = validate_input($_schedule);
        $messages['data']['schedule'] = $schedule;
    }
}

function _validate_work_subdistrict(&$work_subdistrict, &$_work_subdistrict, &$messages, &$has_err)
{
    if (preg_match("/^[\w\s\-\.]*$/", $_work_subdistrict) != 1) {
        $messages["errors"]['work_subdistrict'] = "work_Subdistrict must be alphanumaric and can be include (space, -, .)";
        $has_err = true;
    } else {
        $work_subdistrict = validate_input($_work_subdistrict);
        $messages['data']['work_subdistrict'] = $work_subdistrict;
    }
}

function _validate_area(&$area, &$_area, &$messages, &$has_err)
{
    if (preg_match("/^[\w_\-\.\s,\:#]*$/", $_area) != 1) {
        $messages["errors"]['area'] = "Area must be alphanumaric and can be include (space, : , - _ #)";
        $has_err = true;
    } else {
        $area = validate_input($_area);
        $messages['data']['area'] = $area;
    }
}

function _validate_subdistrict(&$subdistrict, &$_subdistrict, &$messages, &$has_err)
{
    if (preg_match("/^[\w\s\-\.]*$/", $_subdistrict) != 1) {
        $messages["errors"]['subdistrict'] = "Subdistrict must be alphanumaric and can be include (space, -, .)";
        $has_err = true;
    } else {
        $subdistrict = validate_input($_subdistrict);
        $messages['data']['subdistrict'] = $subdistrict;
    }
}

function _validate_district(&$district, &$_district, &$messages, &$has_err)
{
    if (preg_match("/^[\w\s\-\.]*$/", $_district) != 1) {
        $messages["errors"]['district'] = "district must be alphanumaric and can be include (space, -, .)";
        $has_err = true;
    } else {
        $district = validate_input($_district);
        $messages['data']['district'] = $district;
    }
}

function _validate_division(&$division, &$_division, &$messages, &$has_err)
{
    if (preg_match("/^[\w\s\-\.]*$/", $_division) != 1) {
        $messages["errors"]['division'] = "division must be alphanumaric and can be include (space, -, .)";
        $has_err = true;
    } else {
        $division = validate_input($_division);
        $messages['data']['division'] = $division;
    }
}

function _validate_privacy(&$privacy, &$_privacy, &$messages, &$has_err)
{
    if (!isset($_privacy)) {
        $messages["errors"]['privacy'] = "Terms and Condition is required";
        $has_err = true;
    } else if (preg_match("/(on|off)/", $_privacy) != 1) {
        $messages["errors"]['privacy'] = "Terms and Condition is invalid";
        $has_err = true;
    } else {
        $privacy = validate_input($_privacy);
        $messages['data']['privacy'] = $privacy;
    }
}

/**
 * 
 * Registration Validation Controller
 * 
 */


function _validate_utype_registration(&$utype, &$_utype, &$messages, &$has_err)
{
    if (empty($_utype)) {
        $messages["errors"]['utype'] = "User Type is required";
        $has_err = true;
    } else if (preg_match("/(doctor|patient|emanager)/", $_utype) != 1) {
        $messages["errors"]['utype'] = "User Type is invalid";
        $has_err = true;
    } else {
        $utype = validate_input($_utype);
        $messages['data']['utype'] = $utype;
    }
}

/**
 * 
 * Login Validation Controller
 * 
 */

function _validate_email_login(&$email, &$_email, &$messages, &$has_err)
{
    if (empty($_email)) {
        $messages["errors"]['email'] = "Email is required";
        $has_err = true;
    } else if (!filter_var($_email, FILTER_VALIDATE_EMAIL)) {
        $messages["errors"]['email'] = "Email is not valid";
        $has_err = true;
    } else {
        $email = validate_input($_email);
        $messages['data']['email'] = $email;
    }
}

function _validate_password_login(&$password, &$_password, &$messages, &$has_err)
{
    if (empty($_password)) {
        $messages["errors"]['password'] = "Password is required";
        $has_err = true;
    } else {
        // $password = password_hash($_password, PASSWORD_DEFAULT);
        $password = $_password;
        $messages['data']['password'] = $password;
    }
}

function _validate_utype_login(&$utype, &$_utype, &$messages, &$has_err)
{
    if (empty($_utype)) {
        $messages["errors"]['utype'] = "User Type is required";
        $has_err = true;
    } else if (preg_match("/(doctor|patient|emanager|admin)/", $_utype) != 1) {
        $messages["errors"]['utype'] = "User Type is invalid";
        $has_err = true;
    } else {
        $utype = validate_input($_utype);
        $messages['data']['utype'] = $utype;
    }
}

function _validate_rememberme_login(&$rememberme, &$_rememberme, &$messages, &$has_err)
{
    if (isset($_rememberme) && preg_match("/(on|off)/", $_rememberme) != 1) {
        $messages["errors"]['rememberme'] = "Remember me value is invalid";
        $has_err = true;
    } else if (isset($_rememberme)) {
        $rememberme = validate_input($_rememberme);
        $messages['data']['rememberme'] = $rememberme;
    }
}

/**
 * 
 * Change Password Validation Controller
 * 
 */

function _validate_currentpass_change(&$currentpass, &$_currentpass, &$messages, &$has_err)
{
    if (empty($_currentpass)) {
        $messages["errors"]['currentpass'] = "Current Password can't be empty";
        $has_err = true;
    } else if (!password_verify($_currentpass, _get_session_val("password"))) {
        $messages["errors"]['currentpass'] = "Current Password is not corrent";
        $has_err = true;
    } else {
        $currentpass = trim($_currentpass);
        $messages['data']['currentpass'] = $currentpass;
    }
}

function _validate_newpass_change(&$newpass, &$_newpass, &$messages, &$has_err)
{
    if (empty($_newpass)) {
        $messages["errors"]['newpass'] = "New Password can't be empty";
        $has_err = true;
    } else if (strlen(trim($_newpass)) <= 7) {
        $messages["errors"]['newpass'] = "New Password must be 8 characters or greater";
        $has_err = true;
    } else if (!preg_match("/[@#$%]+/", $_newpass)) {
        $messages["errors"]['newpass'] = "New Password must include special characters (@ # $ %)";
        $has_err = true;
    } else if (password_verify($_newpass, _get_session_val("password"))) {
        $messages["errors"]['newpass'] = "New Password must not be same as Current Password";
        $has_err = true;
    } else {
        $newpass = trim($_newpass);
        $messages['data']['newpass'] = $newpass;
    }
}

function _validate_retypepass_change(&$retypepass, &$_retypepass, &$newpass, &$messages, &$has_err)
{
    if (empty($_retypepass)) {
        $messages["errors"]['retypepass'] = "Retype Password can't be empty";
        $has_err = true;
    } else if ($_retypepass != $newpass) {
        $messages["errors"]['retypepass'] = "Retype Password must equal to New Password";
        $has_err = true;
    } else {
        $retypepass = trim($_retypepass);
        $messages['data']['retypepass'] = $retypepass;
    }
}


/**
 * 
 * View User Validation Controller
 * 
 */

function _validate_email_viewuser(&$email, &$_email, &$messages, &$has_err)
{
    if (!empty($_email) && !filter_var($_email, FILTER_VALIDATE_EMAIL)) {
        $messages["errors"]['email'] = "Email is not valid";
        $has_err = true;
    } else {
        $email = validate_input($_email);
        $messages['data']['email'] = $email;
    }
}


/**
 * 
 * Delete User Validation Controller
 * 
 */

function _validate_email_deleteuser(&$email, &$_email, &$messages, &$has_err)
{
    if (!empty($_email) && !filter_var($_email, FILTER_VALIDATE_EMAIL)) {
        $messages["errors"]['email'] = "Email is not valid";
        $has_err = true;
    } else {
        $email = validate_input($_email);
    }
}

function _validate_utype_deleteuser(&$utype, &$_utype, &$messages, &$has_err)
{
    if (empty($_utype)) {
        $messages["errors"]['utype'] = "User Type is required";
        $has_err = true;
    } else if (preg_match("/(doctor|patient|emanager|admin)/", $_utype) != 1) {
        $messages["errors"]['utype'] = "User Type is invalid";
        $has_err = true;
    } else {
        $utype = validate_input($_utype);
    }
}

/**
 * 
 * View Ambulance Validation Controller
 * 
 */

function _validate_phone_viewambulance(&$phone, &$_phone, &$messages, &$has_err)
{
    if (!empty($_phone) && preg_match("/^(\+88)?01[2-9]{1}[0-9]{8}$/", $_phone) != 1) {
        $messages["errors"]['phone'] = "Invalid Phone! valid is +8801234567890, 01234567890";
        $has_err = true;
    } else {
        $phone = validate_input($_phone);
        $messages['data']['phone'] = $phone;
    }
}
