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

if (isset($_GET['id'])) {

    $has_err = false;
    $is_deleted = false;

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

        require_once _ROOT_DIR . "models/Emanager/EmanagerModel.php";

        $is_deleted = EmanagerModel::deleteAmbulance($id);

        if ($is_deleted) {
            $messages['success'] = "Ambulance deleted successfully";
            _set_session_val("messages", $messages);
            header("Location: " . _get_url("users/emanager/view-ambulances.php"));
        } else {
            $messages['unsuccess'] = "Ambulance deleted unsuccessful";
            _set_session_val("messages", $messages);
            header("Location: " . _get_url("users/emanager/view-ambulances.php"));
        }
    } else {
        _set_session_val("messages", $messages);
        header("Location: " . _get_url("users/emanager/view-ambulances.php"));
        exit();
    }
} else {
    header("Location: " . _get_url("users/emanager/view-ambulances.php"));
    exit();
}
