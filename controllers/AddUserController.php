<?php

/**
 * Can access direcly by URL
 */

define("_DIRECT_ACCESS", true);

require_once dirname(dirname(__FILE__)) . "/helper/functions.php";
require_once _ROOT_DIR . "controllers/ValidationController.php";

if (!_get_is_logged_in()) {
    header("Location: " . _get_url("login.php"));
    exit();
}

if (_get_session_val('utype') !== "admin") {
    header("Location: " . _get_url("dashboard.php"));
    exit();
}

if (isset($_POST['add-user'])) {

    $has_err = false;
    $is_duplicate = false;
    $user = null;

    $messages = [
        "unsuccess" => "",
        "success" => "",
        "errors" => [],
        "data" => []
    ];

    $has_duplicate = false;

    $name = "";
    $email = "";
    $phone = "";
    $password = "";
    $cpassword = "";
    $gender = "";
    $utype = "";
    $dob = "";
    $area = "";
    $subdistrict = "";
    $district = "";
    $division = "";

    // _var_dump($_POST);
    // return;


    // Name
    _validate_name($name, $_POST['name'], $messages, $has_err);

    // Email
    _validate_email($email, $_POST['email'], $messages, $has_err);

    // Phone
    _validate_phone($phone, $_POST['phone'], $messages, $has_err);

    // Password
    _validate_password($password, $_POST['password'], $messages, $has_err);

    // Confirm Password
    _validate_cpassword($cpassword, $_POST['cpassword'], $_POST['password'], $messages, $has_err);

    // Gender
    _validate_gender($gender, $_POST['gender'], $messages, $has_err);

    // User Type
    _validate_utype_login($utype, $_POST['utype'], $messages, $has_err);

    // DOB
    _validate_dob($dob, $_POST['dob'], $messages, $has_err);

    // Area
    _validate_area($area, $_POST['area'], $messages, $has_err);

    // Subdistrict
    _validate_subdistrict($subdistrict, $_POST['subdistrict'], $messages, $has_err);

    // District
    _validate_district($district, $_POST['district'], $messages, $has_err);

    // Division
    _validate_division($division, $_POST['division'], $messages, $has_err);


    // _print_r([$name, $email, $password, $cpassword, $gender, $dob, $utype, $privacy]);
    // return;

    // Register the user if no errors found
    if (!$has_err) {

        switch ($utype) {
            case "admin":

                // Admin Registration
                require_once _ROOT_DIR . "models/Admin/AdminModel.php";

                $is_dublication = AdminModel::isDuplicateEmail($email);

                if (!$is_dublication) {
                    $admin = new Admin();

                    $admin->setUName($name);
                    $admin->setUEmail($email);
                    $admin->setUPhone($phone);
                    $admin->setUPassword(password_hash($password, PASSWORD_DEFAULT));
                    $admin->setUGender($gender);
                    $admin->setUDob($dob);

                    $user = AdminModel::createUser($admin);
                }

                break;

            case "doctor":

                // Doctor Registration
                require_once _ROOT_DIR . "models/Doctor/DoctorModel.php";

                $is_dublication = DoctorModel::isDuplicateEmail($email);

                if (!$is_dublication) {
                    $doctor = new Doctor();

                    $doctor->setUName($name);
                    $doctor->setUEmail($email);
                    $doctor->setUPhone($phone);
                    $doctor->setUPassword(password_hash($password, PASSWORD_DEFAULT));
                    $doctor->setUGender($gender);
                    $doctor->setUDob($dob);
                    $doctor->setDArea($area);
                    $doctor->setDSubdistrict($subdistrict);
                    $doctor->setDDistrict($district);
                    $doctor->setDDivision($division);

                    $user = DoctorModel::createUser($doctor);
                }

                break;

            case "emanager":

                // Emergency Manager Registration
                require_once _ROOT_DIR . "models/Emanager/EmanagerModel.php";

                $is_dublication = EmanagerModel::isDuplicateEmail($email);

                if (!$is_dublication) {
                    $emanager = new Emanager();

                    $emanager->setUName($name);
                    $emanager->setUEmail($email);
                    $emanager->setUPhone($phone);
                    $emanager->setUPassword(password_hash($password, PASSWORD_DEFAULT));
                    $emanager->setUGender($gender);
                    $emanager->setUDob($dob);
                    $emanager->setEmArea($area);
                    $emanager->setEmSubdistrict($subdistrict);
                    $emanager->setEmDistrict($district);
                    $emanager->setEmDivision($division);

                    $user = EmanagerModel::createUser($emanager);
                }

                break;

            case "patient":

                // Patient Registration
                require_once _ROOT_DIR . "models/Patient/PatientModel.php";

                $is_dublication = PatientModel::isDuplicateEmail($email);

                if (!$is_dublication) {
                    $patient = new Patient();

                    $patient->setUName($name);
                    $patient->setUEmail($email);
                    $patient->setUPhone($phone);
                    $patient->setUPassword(password_hash($password, PASSWORD_DEFAULT));
                    $patient->setUGender($gender);
                    $patient->setUDob($dob);
                    $patient->setPArea($area);
                    $patient->setPSubdistrict($subdistrict);
                    $patient->setPDistrict($district);
                    $patient->setPDivision($division);

                    $user = PatientModel::createUser($patient);
                }

                break;

            default:

                // Default
                $is_dublication = true;
                $user = null;

                break;
        }

        if (!$is_dublication) {

            if ($user) {
                // Send successful message
                $messages["success"] = "Successfully Added";
                _set_session_val("messages", $messages);
                header("Location: " . _get_url("users/admin/add-user.php"));
            } else {
                // Send successful message
                $messages["unsuccess"] = "Unuccessfully Added";
                _set_session_val("messages", $messages);
                header("Location: " . _get_url("users/admin/add-user.php"));
            }
        } else {
            $messages["unsuccess"] = "Email already exists";
            _set_session_val("messages", $messages);
            header("Location: " . _get_url("users/admin/add-user.php"));
            exit();
        }
    } else {
        _set_session_val("messages", $messages);
        header("Location: " . _get_url("users/admin/add-user.php"));
        exit();
    }
} else {
    header("Location: " . _get_url("users/admin/add-user.php"));
    exit();
}
