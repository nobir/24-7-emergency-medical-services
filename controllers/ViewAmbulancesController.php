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


if (isset($_POST['viewambulances'])) {
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
    $phone = "";

    if (isset($_POST['area'])) {
        $area = $_POST['area'];
        $messages['data']['area'] = $area;
    }

    // Phone
    _validate_phone_viewambulance($phone, $_POST['phone'], $messages, $has_err);

    // _var_dump($phone);
    // _var_dump($area, $phone);
    // exit();

    if (!$has_err) {
        require_once _ROOT_DIR . "models/Emanager/EmanagerModel.php";

        $messages['data']['ambulances'] = EmanagerModel::getAllAmbulances($area, $phone);

        if (count($messages['data']['ambulances']) === 0) {
            $messages['errors']['ambulances'] = false;
        }

        _set_session_val("messages", $messages);
        header("Location: " . _get_url("users/emanager/view-ambulances.php"));
    } else {
        _set_session_val("messages", $messages);
        header("Location: " . _get_url("users/emanager/view-ambulances.php"));
        exit();
    }
} else {
    header("Location: " . _get_url("users/emanager/view-ambulances.php"));
    exit();
}
