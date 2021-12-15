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

if (isset($_POST['hospitalemailajax'])) {

    $has_err = false;
    $is_dublication = false;

    $messages = [
        "unsuccess" => "",
        "success" => "",
        "errors" => [],
        "data" => []
    ];

    $email = "";


    // Email
    _validate_email($email, $_POST['email'], $messages, $has_err);


    // _var_dump($_GET);
    // _var_dump($messages);
    // return;

    // If no error
    if (!$has_err) {

        // Doctor Registration
        require_once _ROOT_DIR . "models/Hospital/Hospital.php";
        require_once _ROOT_DIR . "models/Emanager/EmanagerModel.php";

        $is_dublication = EmanagerModel::isDuplicateHospitalEmail($email);
        if ($is_dublication) {
            $messages["data"] = [];
            $messages["errors"]['email'] = "Email is already registered.";
        }
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
