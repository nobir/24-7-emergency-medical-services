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

if (isset($_POST['changepp'])) {

    $upload_ok = false;

    $messages = [
        "success" => "",
        "unsuccess" => "",
        "errors" => [],
        "data" => []
    ];

    $picture = "";

    // _var_dump($_POST);
    // _var_dump($_FILES);
    // return;

    if ($_FILES['picture']['error'] != 0) {
        $messages["errors"]['picture'] = "Choose a image file";
        $upload_ok = false;
    } else {
        $upload_dir = _ROOT_DIR . _CONFIG['UPLOAD_DIR'];
        $file_name = basename($_FILES["picture"]["name"]);
        $target_file = $upload_dir . _get_session_val('email') . "_" . $file_name;
        $image_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        $check = getimagesize($_FILES["picture"]["tmp_name"]);

        if ($check === false) {
            $messages["errors"]['picture'] = "File is not an image.";
            $upload_ok = false;
        } else if (file_exists($target_file)) {
            $messages["errors"]['picture'] = "Image already exits";
            $upload_ok = false;
        } else if ($_FILES['picture']['size'] > (4 * 1024 * 1024)) {  // 4MB
            $messages["errors"]['picture'] = "Image size must be less than 4MB";
            $upload_ok = false;
        } else if (!preg_match("/jpeg|jpg|png/", $image_type)) {
            $messages["errors"]['picture'] = "Image format must be jpeg or jpg or png";
            $upload_ok = false;
        } else {
            $picture = _get_session_val('email') . "_" . $file_name;
            $upload_ok = true;
        }
    }

    // _var_dump($picture);
    // _var_dump($messages);
    // exit();

    // Move the actual file to uploads directory
    if ($upload_ok) {

        require_once _ROOT_DIR . "models/Model.php";

        if (Model::changeProfilePicture($picture, _get_session_val('uid')) && move_uploaded_file($_FILES["picture"]["tmp_name"], $target_file)) {
            // Send successful message
            _set_session_val("pp_path", $picture);
            $messages["success"] = "Successfully Changed Profile Picture";
            _set_session_val("messages", $messages);
            header("Location: " . _get_url("dashboard/change-pp.php"));
        } else {
            $messages["unsuccess"] = "There was an error to uploading your image";
            $upload_ok = false;

            _set_session_val("messages", $messages);
            header("Location: " . _get_url("dashboard/change-pp.php"));
            exit();
        }
    } else {
        _set_session_val("messages", $messages);
        header("Location: " . _get_url("dashboard/change-pp.php"));
        exit();
    }
} else {
    header("Location: " . _get_url("dashboard/change-pp.php"));
    exit();
}
