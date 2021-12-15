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

if (_get_session_val('utype') !== "patient") {
    header("Location: " . _get_url("dashboard.php"));
    exit();
}

if (isset($_POST['viewdoctors'])) {
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
        require_once _ROOT_DIR . "models/Patient/PatientModel.php";

        $messages['data']['users'] = PatientModel::getAllDoctors($name, $email);

        if (count($messages['data']['users']) === 0) {
            $messages['errors']['users'] = false;
        }

        _set_session_val("messages", $messages);
        header("Location: " . _get_url("users/patient/view-doctors.php"));
    } else {
        _set_session_val("messages", $messages);
        header("Location: " . _get_url("users/patient/view-doctors.php"));
        exit();
    }
} else {
    header("Location: " . _get_url("users/patient/view-doctors.php"));
    exit();
}
