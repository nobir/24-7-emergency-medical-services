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

if (isset($_POST['ambulancephoneajax'])) {

    $has_err = false;
    $is_dublication = false;

    $messages = [
        "unsuccess" => "",
        "success" => "",
        "errors" => [],
        "data" => []
    ];

    $phone = "";


    // Phone
    _validate_phone($phone, $_POST['phone'], $messages, $has_err);


    // _var_dump($_GET);
    // _var_dump($messages);
    // return;

    // If no error
    if (!$has_err) {

        // Doctor Registration
        require_once _ROOT_DIR . "models/Ambulance/Ambulance.php";
        require_once _ROOT_DIR . "models/Emanager/EmanagerModel.php";

        $is_dublication = EmanagerModel::isDuplicateAmbulancePhone($phone);
        if ($is_dublication) {
            $messages["data"] = [];
            $messages["errors"]['phone'] = "This phone number is already registered.";
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
