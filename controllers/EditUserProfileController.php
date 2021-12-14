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

if (isset($_POST['edit-profile'])) {

    $has_err = false;
    $is_duplicate = false;
    $is_update = false;

    $messages = [
        "unsuccess" => "",
        "success" => "",
        "errors" => [],
        "data" => []
    ];

    $has_duplicate = false;

    $_id = $_POST['_id'];
    $_email = $_POST['_email'];
    $_utype = $_POST['_utype'];


    $name = "";
    $email = "";
    $phone = "";
    $gender = "";
    $dob = "";

    $degree = "";
    $specialization = "";
    $schedule = "";

    $work_subdistrict = "";

    $area = "";
    $subdistrict = "";
    $district = "";
    $division = "";
    $privacy = "";

    // _var_dump($_POST);
    // return;


    // Name
    _validate_name($name, $_POST['name'], $messages, $has_err);

    // Email
    _validate_email($email, $_POST['email'], $messages, $has_err);

    // Phone
    _validate_phone($phone, $_POST['phone'], $messages, $has_err);

    // Gender
    _validate_gender($gender, $_POST['gender'], $messages, $has_err);

    // DOB
    _validate_dob($dob, $_POST['dob'], $messages, $has_err);

    if (_get_session_val('utype') === "doctor") {

        // Degree
        _validate_degree($degree, $_POST['degree'], $messages, $has_err);

        // Specialization
        _validate_specialization($specialization, $_POST['specialization'], $messages, $has_err);

        // Schedule
        _validate_schedule($schedule, $_POST['schedule'], $messages, $has_err);
    } else if (_get_session_val('utype') === "emanager") {

        // Work Subdistrict
        _validate_work_subdistrict($work_subdistrict, $_POST['work_subdistrict'], $messages, $has_err);
    }

    // Area
    _validate_area($area, $_POST['area'], $messages, $has_err);

    // Subdistrict
    _validate_subdistrict($subdistrict, $_POST['subdistrict'], $messages, $has_err);

    // District
    _validate_district($district, $_POST['district'], $messages, $has_err);

    // Division
    _validate_division($division, $_POST['division'], $messages, $has_err);

    // _print_r([$name, $email, $gender, $dob, $_email, $_utype, $_id]);
    // _var_dump($has_err);
    // _var_dump($_POST);
    // _var_dump($messages);
    // return;

    // Register the user if no errors found
    if (!$has_err) {

        switch ($_utype) {
            case "admin":

                // Admin Edit
                require_once _ROOT_DIR . "models/Admin/AdminModel.php";

                if ($_email !== $email) {
                    $is_dublication = AdminModel::isDuplicateEmail($email);
                } else {
                    $is_dublication = false;
                }

                if (!$is_dublication) {

                    $admin = new Admin();

                    $admin->setAId($_id);
                    $admin->setUName($name);
                    $admin->setUEmail($email);
                    $admin->setUPhone($phone);
                    $admin->setUGender($gender);
                    $admin->setUDob($dob);

                    $is_update = AdminModel::updateUser($admin);
                }

                break;
            case "doctor":

                // Doctor Edit
                require_once _ROOT_DIR . "models/Doctor/DoctorModel.php";

                if ($_email !== $email) {
                    $is_dublication = DoctorModel::isDuplicateEmail($email);
                } else {
                    $is_dublication = false;
                }

                if (!$is_dublication) {

                    $doctor = new Doctor();

                    $doctor->setDId($_id);
                    $doctor->setUName($name);
                    $doctor->setUEmail($email);
                    $doctor->setUPhone($phone);
                    $doctor->setUGender($gender);
                    $doctor->setUDob($dob);

                    $doctor->setDDegree($degree);
                    $doctor->setDSpecialization($specialization);
                    $doctor->setDSchedule($schedule);

                    $doctor->setDArea($area);
                    $doctor->setDSubdistrict($subdistrict);
                    $doctor->setDDistrict($district);
                    $doctor->setDDivision($division);

                    // _var_dump($doctor);
                    // exit();

                    $is_update = DoctorModel::updateUser($doctor);
                }

                break;

            case "emanager":

                // Emergency Manager Edit
                require_once _ROOT_DIR . "models/Emanager/EmanagerModel.php";

                if ($_email !== $email) {
                    $is_dublication = EmanagerModel::isDuplicateEmail($email);
                } else {
                    $is_dublication = false;
                }

                if (!$is_dublication) {
                    $emanager = new Emanager();

                    $emanager->setEmId($_id);
                    $emanager->setUName($name);
                    $emanager->setUEmail($email);
                    $emanager->setUPhone($phone);
                    $emanager->setUGender($gender);
                    $emanager->setUDob($dob);

                    $emanager->setEmWorkArea($work_subdistrict);

                    $emanager->setEmArea($area);
                    $emanager->setEmSubdistrict($subdistrict);
                    $emanager->setEmDistrict($district);
                    $emanager->setEmDivision($division);

                    $is_update = EmanagerModel::updateUser($emanager);
                }

                break;

            case "patient":

                // Patient Edit
                require_once _ROOT_DIR . "models/Patient/PatientModel.php";

                if ($_email !== $email) {
                    $is_dublication = PatientModel::isDuplicateEmail($email);
                } else {
                    $is_dublication = false;
                }

                if (!$is_dublication) {
                    $patient = new Patient();

                    $patient->setPId($_id);
                    $patient->setUName($name);
                    $patient->setUEmail($email);
                    $patient->setUPhone($phone);
                    $patient->setUGender($gender);
                    $patient->setUDob($dob);

                    $patient->setPArea($area);
                    $patient->setPSubdistrict($subdistrict);
                    $patient->setPDistrict($district);
                    $patient->setPDivision($division);

                    $is_update = PatientModel::updateUser($patient);
                }

                break;

            default:

                // Default
                $is_dublication = true;
                $is_update = false;

                break;
        }

        // _var_dump($is_update);
        // exit();

        if (!$is_dublication) {

            if ($is_update) {
                // Send successful message
                $messages["success"] = "Successfully Save";
                _set_session_val("messages", $messages);
                header("Location: " . _get_url("users/admin/edit-user.php?email=".$_email."&utype=".$_utype));
            } else {
                // Send successful message
                $messages["unsuccess"] = "No Changes";
                _set_session_val("messages", $messages);
                header("Location: " . _get_url("users/admin/edit-user.php?email=".$_email."&utype=".$_utype));
            }
        } else {
            $messages["unsuccess"] = "Email already Registered";
            _set_session_val("messages", $messages);
            header("Location: " . _get_url("users/admin/edit-user.php?email=".$_email."&utype=".$_utype));
            exit();
        }
    } else {
        _set_session_val("messages", $messages);
        header("Location: " . _get_url("users/admin/edit-user.php?email=".$_email."&utype=".$_utype));
        exit();
    }
} else {
    header("Location: " . _get_url("users/admin/edit-user.php?email=".$_email."&utype=".$_utype));
    exit();
}
