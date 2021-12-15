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


if (isset($_POST['edit-ambulance'])) {

    $has_err = false;
    $ambulance = null;
    $is_update = false;

    $messages = [
        "unsuccess" => "",
        "success" => "",
        "errors" => [],
        "data" => []
    ];

    $phone = "";

    $area = "";
    $subdistrict = "";
    $district = "";
    $division = "";

    // _var_dump($_POST);
    // return;

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

    // _print_r([$phone, $area, $subdistrict, $district, $division]);
    // _print_r($messages);
    // return;

    // Register the user if no errors found
    if (!$has_err) {

        // Doctor Registration
        require_once _ROOT_DIR . "models/Ambulance/Ambulance.php";
        require_once _ROOT_DIR . "models/Emanager/EmanagerModel.php";

        if($_POST['_phone'] != $phone) {
            $is_dublication = EmanagerModel::isDuplicateAmbulancePhone($phone);
        }

        if (!$is_dublication) {
            $ambulance = new Ambulance();

            $ambulance->setAmId($_POST['_id']);
            $ambulance->setAmPhone($phone);
            $ambulance->setAmArea($area);
            $ambulance->setAmSubdistrict($subdistrict);
            $ambulance->setAmDistrict($district);
            $ambulance->setAmDivision($division);

            $is_update = EmanagerModel::updateAmbulance($ambulance);
        }

        if (!$is_dublication) {

            if ($is_update) {
                // Send successful message
                $messages["success"] = "Successfully Edited";
                _set_session_val("messages", $messages);
                header("Location: " . _get_url("users/emanager/edit-ambulance.php?id=" . $_POST['_id']));
            } else {
                // Send successful message
                $messages["unsuccess"] = "Unuccessfully Edited";
                _set_session_val("messages", $messages);
                header("Location: " . _get_url("users/emanager/edit-ambulance.php?id=" . $_POST['_id']));
            }
        } else {
            $messages["unsuccess"] = "Phone already Edited";
            _set_session_val("messages", $messages);
            header("Location: " . _get_url("users/emanager/edit-ambulance.php?id=" . $_POST['_id']));
            exit();
        }
    } else {
        _set_session_val("messages", $messages);
        header("Location: " . _get_url("users/emanager/edit-ambulance.php?id=" . $_POST['_id']));
        exit();
    }
} else {
    header("Location: " . _get_url("users/emanager/edit-ambulance.php?id=" . $_POST['_id']));
    exit();
}
