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

if (isset($_POST['viewhospitals'])) {
    // _var_dump($_POST);
    // return;

    $has_err = false;

    $messages = [
        "unsuccess" => "",
        "success" => "",
        "errors" => [],
        "data" => []
    ];

    $area = "";
    $email = "";

    // Area
    _validate_area($area, $_POST['area'], $messages, $has_err);

    // Email
    _validate_email_viewuser($email, $_POST['email'], $messages, $has_err);

    // _var_dump($_POST);
    // _var_dump($email);
    // exit();

    if (!$has_err) {
        require_once _ROOT_DIR . "models/Patient/PatientModel.php";

        $messages['data']['hospitals'] = PatientModel::getAllHospitals($area, $email);

        if (count($messages['data']['hospitals']) === 0) {
            $messages['errors']['hospitals'] = false;
        }

        _set_session_val("messages", $messages);
        header("Location: " . _get_url("users/emanager/view-hospitals.php"));
    } else {
        _set_session_val("messages", $messages);
        header("Location: " . _get_url("users/emanager/view-hospitals.php"));
        exit();
    }
} else {
    header("Location: " . _get_url("users/emanager/view-hospitals.php"));
    exit();
}
