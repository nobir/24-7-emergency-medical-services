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

if (isset($_POST['appointment'])) {

    $has_err = false;
    $is_duplicate = false;
    $doctor = null;

    $messages = [
        "unsuccess" => "",
        "success" => "",
        "errors" => [],
        "data" => []
    ];

    $has_duplicate = false;

    $reason = "";
    $email = "";

    // _var_dump($_POST);
    // return;


    // Name
    _validate_name($reason, $_POST['reason'], $messages, $has_err);

    // email
    _validate_email($email, $_POST['docemail'], $messages, $has_err);

    // _print_r([$reason, $email]);
    // return;

    // Register the user if no errors found
    if (!$has_err) {

        require_once _ROOT_DIR . "models/Doctor/DoctorModel.php";
        
        $doctor = DoctorModel::getUserByEmail($email);
        
        if ($doctor) {
            require_once _ROOT_DIR . "models/Patient/PatientModel.php";

            if(PatientModel::requestAppointment($reason, $doctor['d_id'], _get_session_val('id'))) {

                // Send successful message
                $messages["success"] = "Successfully Appointed";
                _set_session_val("messages", $messages);
                header("Location: " . _get_url("users/patient/request-appointment.php"));
            } else {

                $messages["success"] = "Unsuccessfully Appointed";
                _set_session_val("messages", $messages);
                header("Location: " . _get_url("users/patient/request-appointment.php"));
            }

        } else {
            // Send successful message
            $messages["unsuccess"] = "Doctor not found";
            _set_session_val("messages", $messages);
            header("Location: " . _get_url("users/patient/request-appointment.php"));
        }
    } else {
        _set_session_val("messages", $messages);
        header("Location: " . _get_url("users/patient/request-appointment.php"));
        exit();
    }
} else {
    header("Location: " . _get_url("users/patient/request-appointment.php"));
    exit();
}
