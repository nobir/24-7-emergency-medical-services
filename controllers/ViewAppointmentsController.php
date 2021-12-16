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

if (isset($_POST['viewappointments'])) {
    // _var_dump($_POST);
    // return;

    $has_err = false;

    $messages = [
        "unsuccess" => "",
        "success" => "",
        "errors" => [],
        "data" => []
    ];

    $name = "";
    $email = "";

    if (isset($_POST['name'])) {
        $name = $_POST['name'];
        $messages['data']['name'] = $name;
    }

    // Email
    _validate_email_viewuser($email, $_POST['email'], $messages, $has_err);

    // _var_dump($email);
    // _var_dump($name, $email);
    // exit();

    if (!$has_err) {
        require_once _ROOT_DIR . "models/Doctor/DoctorModel.php";

        $messages['data']['appointments'] = DoctorModel::getAppointments(_get_session_val('id'), $name, $email);

        if (count($messages['data']['appointments']) === 0) {
            $messages['errors']['appointments'] = false;
        }

        _set_session_val("messages", $messages);
        header("Location: " . _get_url("users/doctor/view-appointments.php"));
    } else {
        _set_session_val("messages", $messages);
        header("Location: " . _get_url("users/doctor/view-appointments.php"));
        exit();
    }
} else {
    header("Location: " . _get_url("users/doctor/view-appointments.php"));
    exit();
}
