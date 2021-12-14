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

if (isset($_GET['email']) && isset($_GET['utype'])) {

    $has_err = false;
    $is_deleted = false;

    $messages = [
        "unsuccess" => "",
        "success" => "",
        "errors" => [],
        "data" => []
    ];

    $email = "";
    $utype = "";

    // ID
    _validate_email_deleteuser($email, $_GET['email'], $messages, $has_err);

    // User type
    _validate_utype_deleteuser($utype, $_GET['utype'], $messages, $has_err);



    if (!$has_err) {

        switch ($utype) {
            case 'admin':

                require_once _ROOT_DIR . "models/Admin/AdminModel.php";

                $admin = AdminModel::getUserByEmail($email);

                if ($admin) {

                    $is_deleted = AdminModel::deleteUser($admin['a_id']);
                }

                break;
            case 'doctor':

                require_once _ROOT_DIR . "models/Doctor/DoctorModel.php";

                $doctor = DoctorModel::getUserByEmail($email);


                if ($doctor) {

                    $is_deleted = DoctorModel::deleteUser($doctor['d_id']);
                }

                break;
            case 'emanager':

                require_once _ROOT_DIR . "models/Emanager/EmanagerModel.php";

                $emanager = EmanagerModel::getUserByEmail($email);

                if ($emanager) {

                    $is_deleted = EmanagerModel::deleteUser($emanager['em_id']);
                }

                break;
            case 'patient':

                require_once _ROOT_DIR . "models/Patient/PatientModel.php";
                $patient = PatientModel::getUserByEmail($email);


                if ($patient) {

                    $is_deleted = PatientModel::deleteUser($patient['p_id']);
                }

                // _var_dump($is_deleted);
                // exit();

                break;
            default:
                $messages['unsuccess'] = "Invalid user type";
                $has_err = true;
                break;
        }

        if ($is_deleted) {
            $messages['success'] = "User deleted successfully";
            _set_session_val("messages", $messages);
            header("Location: " . _get_url("users/admin/view-users.php"));
        } else {
            $messages['unsuccess'] = "User deleted unsuccessful";
            _set_session_val("messages", $messages);
            header("Location: " . _get_url("users/admin/view-users.php"));
        }
    } else {
        _set_session_val("messages", $messages);
        header("Location: " . _get_url("users/admin/view-users.php"));
        exit();
    }
} else {
    header("Location: " . _get_url("users/admin/view-users.php"));
    exit();
}
