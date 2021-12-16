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

if (_get_session_val('utype') !== "doctor") {
    header("Location: " . _get_url("dashboard.php"));
    exit();
}

if (isset($_GET['id'])) {

    $has_err = false;
    $is_accept = false;

    $messages = [
        "unsuccess" => "",
        "success" => "",
        "errors" => [],
        "data" => []
    ];

    $id = "";

    // ID
    if (!is_numeric($_GET['id'])) {
        $messages["errors"]['id'] = "Invalid ID";
        $has_err = true;
    } else {
        $id = validate_input($_GET['id']);
        $messages['data']['id'] = $id;
    }

    if (!$has_err) {

        require_once _ROOT_DIR . "models/Doctor/DoctorModel.php";

        $is_accept = DoctorModel::acceptAppointment($id);

        if ($is_accept) {
            $messages['success'] = "Accept Appointment successfully";
            _set_session_val("messages", $messages);
            header("Location: " . _get_url("users/doctor/view-appointments.php"));
        } else {
            $messages['unsuccess'] = "Accept Appointment unsuccessful";
            _set_session_val("messages", $messages);
            header("Location: " . _get_url("users/doctor/view-appointments.php"));
        }
    } else {
        _set_session_val("messages", $messages);
        header("Location: " . _get_url("users/doctor/view-appointments.php"));
        exit();
    }
} else {
    header("Location: " . _get_url("users/doctor/view-appointments.php"));
    exit();
}
