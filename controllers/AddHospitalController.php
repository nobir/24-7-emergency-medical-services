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

if (_get_session_val('utype') !== "emanager") {
    header("Location: " . _get_url("dashboard.php"));
    exit();
}


if (isset($_POST['add-hospital'])) {

    $has_err = false;
    $ambulance = null;
    $is_created = false;

    $messages = [
        "unsuccess" => "",
        "success" => "",
        "errors" => [],
        "data" => []
    ];

    $name = "";
    $email = "";
    $phone = "";

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

    // Area
    _validate_area($area, $_POST['area'], $messages, $has_err);

    // Subdistrict
    _validate_subdistrict($subdistrict, $_POST['subdistrict'], $messages, $has_err);

    // District
    _validate_district($district, $_POST['district'], $messages, $has_err);

    // Division
    _validate_division($division, $_POST['division'], $messages, $has_err);

    // _print_r($_POST);
    // _print_r([$name, $email, $phone, $area, $subdistrict, $district, $division]);
    // _print_r($messages);
    // return;

    // Register the user if no errors found
    if (!$has_err) {

        // Doctor Registration
        require_once _ROOT_DIR . "models/Hospital/Hospital.php";
        require_once _ROOT_DIR . "models/Emanager/EmanagerModel.php";

        $is_dublication = EmanagerModel::isDuplicateHospitalEmail($email);

        if (!$is_dublication) {
            $hospital = new Hospital();

            $hospital->setHName($name);
            $hospital->setHEmail($email);
            $hospital->setHPhone($phone);
            $hospital->setHArea($area);
            $hospital->setHSubdistrict($subdistrict);
            $hospital->setHDistrict($district);
            $hospital->setHDivision($division);

            $is_created = EmanagerModel::createHospital($hospital);
        }

        if (!$is_dublication) {

            if ($is_created) {
                // Send successful message
                $messages["success"] = "Successfully Added";
                _set_session_val("messages", $messages);
                header("Location: " . _get_url("users/emanager/add-hospital.php"));
            } else {
                // Send successful message
                $messages["unsuccess"] = "Unuccessfully Added";
                _set_session_val("messages", $messages);
                header("Location: " . _get_url("users/emanager/add-hospital.php"));
            }
        } else {
            $messages["unsuccess"] = "Email already Added";
            _set_session_val("messages", $messages);
            header("Location: " . _get_url("users/emanager/add-hospital.php"));
            exit();
        }
    } else {
        _set_session_val("messages", $messages);
        header("Location: " . _get_url("users/emanager/add-hospital.php"));
        exit();
    }
} else {
    header("Location: " . _get_url("users/emanager/add-hospital.php"));
    exit();
}
