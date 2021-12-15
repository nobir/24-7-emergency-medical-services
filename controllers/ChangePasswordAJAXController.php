<?php

/**
 * Can access direcly by URL
 */

define("_DIRECT_ACCESS", true);

require_once dirname(dirname(__FILE__)) . "/helper/functions.php";
require_once _ROOT_DIR . "controllers/ValidationController.php";


if (!_get_is_logged_in()) {
    header("Location: ../login.php");
    exit();
}

if (isset($_POST['changepasswordajax'])) {

    $has_err = false;

    $messages = [
        "unsuccess" => "",
        "success" => "",
        "errors" => [],
        "data" => []
    ];

    $currentpass = "";
    $newpass = "";
    $retypepass = "";


    // Current Password
    _validate_currentpass_change($currentpass, $_POST['currentpass'], $messages, $has_err);

    // New Password
    _validate_newpass_change($newpass, $_POST['newpass'], $messages, $has_err);

    // Retype Password
    _validate_retypepass_change($retypepass, $_POST['retypepass'], $newpass, $messages, $has_err);

    // _var_dump($_POST);
    // _var_dump($messages);
    // return;

    // If no error
    if (!$has_err) {
        echo json_encode($messages);
    } else {
        echo json_encode($messages);
        exit();
    }
} else {
    echo json_encode([
        "unsuccess" => "Server request error",
    ]);
    exit();
}
