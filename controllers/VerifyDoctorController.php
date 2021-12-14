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


if (isset($_GET['d_id'])) {

    $has_err = false;

    $messages = [
        "unsuccess" => "",
        "success" => "",
        "errors" => [],
        "data" => []
    ];

    $d_id = "";

    if (!is_numeric($_GET['d_id'])) {
        $messages['unsuccess'] = "Invalid doctor id";
        $has_err = true;
    } else {
        $d_id = $_GET['d_id'];
    }

    if (!$has_err) {
        require_once _ROOT_DIR . "models/Admin/AdminModel.php";

        if (AdminModel::verifyDoctor($d_id)) {
            $messages['success'] = "Doctor verified successfully";
            _set_session_val("messages", $messages);
            header("Location: " . _get_url("users/admin/verify-doctor.php"));
        } else {
            $messages['unsuccess'] = "Doctor verified unsuccessful";
            _set_session_val("messages", $messages);
            header("Location: " . _get_url("users/admin/verify-doctor.php"));
        }
    } else {
        _set_session_val("messages", $messages);
        header("Location: " . _get_url("users/admin/verify-doctor.php"));
        exit();
    }
} else {
    header("Location: " . _get_url("users/admin/verify-doctor.php"));
    exit();
}
