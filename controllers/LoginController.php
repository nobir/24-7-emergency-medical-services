<?php

/**
 * Can access direcly by URL
 */

define("_DIRECT_ACCESS", true);

require_once dirname(__FILE__, 2) . "/helper/functions.php";
require_once _ROOT_DIR . "controllers/ValidationController.php";

if (isset($_POST['login'])) {

    $has_err = false;
    $is_verify = true;

    $messages = [
        "success" => "",
        "unsuccess" => "",
        "errors" => [],
        "data" => []
    ];

    $email = "";
    $password = "";
    $utype = "";
    $rememberme = "";

    // _var_dump($_POST);
    // return;

    // Email
    _validate_email_login($email, $_POST['email'], $messages, $has_err);

    // Password
    _validate_password_login($password, $_POST['password'], $messages, $has_err);

    // User Type
    _validate_utype_login($utype, $_POST['utype'], $messages, $has_err);

    // Remember me
    _validate_rememberme_login($rememberme, $_POST['rememberme'], $messages, $has_err);


    // _print_r([$email, $password, $utype, $rememberme]);
    // exit();

    // Login the user if no errors found
    if (!$has_err) {

        switch ($utype) {
            case "admin":

                // Admin Login

                require_once _ROOT_DIR . "models/Admin/AdminModel.php";

                $auth_user = AdminModel::authUser($email, $password);

                // _var_dump($auth_user);
                // _print_r($auth_user);
                // exit();

                _set_session_val('id', $auth_user['a_id']);
                _set_session_val('uid', $auth_user['u_id']);
                _set_session_val('name', $auth_user['a_name']);
                _set_session_val('email', $auth_user['a_email']);
                _set_session_val('phone', $auth_user['a_phone']);
                _set_session_val('password', $auth_user['a_password']);
                _set_session_val('gender', $auth_user['a_gender']);
                _set_session_val('dob', $auth_user['a_dob']);
                _set_session_val('utype', $auth_user['utype']);
                _set_session_val('pp_path', $auth_user['a_pp_path']);

                break;

            case "doctor":

                // Doctor Login
                require_once _ROOT_DIR . "models/Doctor/DoctorModel.php";

                $auth_user = DoctorModel::authUser($email, $password);

                // _var_dump($auth_user);
                // _print_r($auth_user);
                // exit();

                if ($auth_user['d_verify'] === 0) {
                    $is_verify = false;
                } else {
                    _set_session_val('id', $auth_user['d_id']);
                    _set_session_val('uid', $auth_user['u_id']);
                    _set_session_val('adid', $auth_user['ad_id']);
                    _set_session_val('name', $auth_user['d_name']);
                    _set_session_val('email', $auth_user['d_email']);
                    _set_session_val('phone', $auth_user['d_phone']);
                    _set_session_val('password', $auth_user['d_password']);
                    _set_session_val('gender', $auth_user['d_gender']);
                    _set_session_val('dob', $auth_user['d_dob']);
                    _set_session_val('utype', $auth_user['utype']);
                    _set_session_val('pp_path', $auth_user['d_pp_path']);

                    _set_session_val('degree', $auth_user['d_degree']);
                    _set_session_val('specialization', $auth_user['d_specialization']);
                    _set_session_val('schedule', $auth_user['d_schedule']);
                    _set_session_val('verify', $auth_user['d_verify']);

                    _set_session_val('area', $auth_user['d_area']);
                    _set_session_val('subdistrict', $auth_user['d_subdistrict']);
                    _set_session_val('district', $auth_user['d_district']);
                    _set_session_val('division', $auth_user['d_division']);
                }


                break;

            case "emanager":

                // Emergency Manager Login
                require_once _ROOT_DIR . "models/Emanager/EmanagerModel.php";

                $auth_user = EmanagerModel::authUser($email, $password);

                // _var_dump($auth_user);
                // _print_r($auth_user);
                // exit();

                _set_session_val('id', $auth_user['em_id']);
                _set_session_val('uid', $auth_user['u_id']);
                _set_session_val('aid', $auth_user['ad_id']);
                _set_session_val('name', $auth_user['em_name']);
                _set_session_val('email', $auth_user['em_email']);
                _set_session_val('phone', $auth_user['em_phone']);
                _set_session_val('password', $auth_user['em_password']);
                _set_session_val('gender', $auth_user['em_gender']);
                _set_session_val('dob', $auth_user['em_dob']);
                _set_session_val('utype', $auth_user['utype']);
                _set_session_val('pp_path', $auth_user['em_pp_path']);

                _set_session_val('work_subdistrict', $auth_user['em_work_subdistrict']);

                _set_session_val('area', $auth_user['em_area']);
                _set_session_val('subdistrict', $auth_user['em_subdistrict']);
                _set_session_val('district', $auth_user['em_district']);
                _set_session_val('division', $auth_user['em_division']);

                break;

            case "patient":

                // Patient Login
                require_once _ROOT_DIR . "models/Patient/PatientModel.php";

                $auth_user = PatientModel::authUser($email, $password);

                // _var_dump($auth_user);
                // _print_r($auth_user);
                // exit();

                _set_session_val('id', $auth_user['p_id']);
                _set_session_val('uid', $auth_user['u_id']);
                _set_session_val('adid', $auth_user['ad_id']);
                _set_session_val('name', $auth_user['p_name']);
                _set_session_val('email', $auth_user['p_email']);
                _set_session_val('phone', $auth_user['p_phone']);
                _set_session_val('password', $auth_user['p_password']);
                _set_session_val('gender', $auth_user['p_gender']);
                _set_session_val('dob', $auth_user['p_dob']);
                _set_session_val('utype', $auth_user['utype']);
                _set_session_val('pp_path', $auth_user['p_pp_path']);

                _set_session_val('area', $auth_user['p_area']);
                _set_session_val('subdistrict', $auth_user['p_subdistrict']);
                _set_session_val('district', $auth_user['p_district']);
                _set_session_val('division', $auth_user['p_division']);

                break;

            default:

                // Default
                $auth_user = null;

                break;
        }

        if ($auth_user) {
            if ($is_verify) {
                _set_logged_in(true);

                // Set remember me if checked
                if ($rememberme === "on") {
                    $params = session_get_cookie_params();

                    setcookie('email', _get_session_val('email'), time() + _CONFIG['EXPIRED'], $params['path'], $params['domain'], $params['secure'], $params['httponly']);
                    setcookie('expire', time() + _CONFIG['EXPIRED'], time() + _CONFIG['EXPIRED'], $params['path'], $params['domain'], $params['secure'], $params['httponly']);
                    setcookie('utype', _get_session_val('utype'), time() + _CONFIG['EXPIRED'], $params['path'], $params['domain'], $params['secure'], $params['httponly']);
                }

                $messages["success"] = "Login Successful";
                _set_session_val("messages", $messages);
                header("Location: " . _get_url("dashboard/index.php"));
                exit();
            } else {
                $messages["unsuccess"] = "Your are not verify yet please wait for verification by an admin";
                _set_session_val("messages", $messages);
                header("Location: " . _get_url("login.php"));
                exit();
            }
        } else {
            $messages["unsuccess"] = "Your credential is not correct";
            _set_session_val("messages", $messages);
            header("Location: " . _get_url("login.php"));
            exit();
        }
    } else {
        _set_session_val("messages", $messages);
        header("Location: " . _get_url("login.php"));
        exit();
    }
} else {
    header("Location: " . _get_url("login.php"));
    exit();
}
