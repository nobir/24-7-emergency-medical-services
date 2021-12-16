<?php

/**
 * Can't access directly by URL
 */

defined("_DIRECT_ACCESS") or exit("<h1>Your are not allowed</h1>");


/**
 * Start the session
 * for all `View page`
 */

session_start();

/**
 * 
 * Defined CONSTAN
 * 
 */

/**
 * return root directory
 * 
 * Example: `~\htdocs/MyProject/` from `xampp`
 */

define("_ROOT_DIR", dirname(dirname(__FILE__)) . "/");


/**
 * return all the configuration in array which is
 * defined in the `model/config.php` file
 * 
 * Example: `~\htdocs/MyProject/` from `xampp`
 * 
 * @return array
 */

define("_CONFIG", (file_exists(_ROOT_DIR . "models/Config.php")) ? require_once(_ROOT_DIR . "models/Config.php") : null);


/**
 * Includes templates file
 */

if (file_exists(_ROOT_DIR . "templates/header.php")) {
    require_once(_ROOT_DIR . "templates/header.php");
}

if (file_exists(_ROOT_DIR . "templates/footer.php")) {
    require_once(_ROOT_DIR . "templates/footer.php");
}


if (file_exists(_ROOT_DIR . "templates/menu.php")) {
    require_once(_ROOT_DIR . "templates/menu.php");
}


/**
 * 
 * Usefull Function
 * 
 */


/**
 * 
 * If `$_SESSION[$key]` is exist
 * return the value in it
 * otherwise return empty
 * `return mixed`
 * 
 * @return mixed
 */

function _get_session_val($key)
{
    if (isset($_SESSION[$key])) {
        return $_SESSION[$key];
    }
}


/**
 * 
 * `$_SESSION[$key]` setter
 * `return void`
 * 
 * @return void
 */

function _set_session_val($key, $value)
{
    $_SESSION[$key] = $value;
}


/**
 * 
 * If `$_SESSION['loggedin']` is true
 * `return true`
 * otherwise `return false`
 * 
 * @return bool
 */

function _get_is_logged_in()
{
    if (isset($_SESSION['loggedin'])) {
        return $_SESSION['loggedin'] == true;
    }

    return false;
}


/**
 * 
 * Set the `$_SESSION['logged']`
 * if `session` is started
 * from given parameter
 * 
 * @param bool $loggedin
 * @return null
 */

function _set_logged_in(bool $loggedin)
{
    if (session_status() === 2) {
        $_SESSION['loggedin'] = $loggedin;
    }
}

// _var_dump(_set_logged_in(false)); // NULL

/**
 * 
 * Display information with
 * proper formating using `var_dump()`
 * 
 * @param expression $expression
 * @return null
 */

function _var_dump($expression)
{
    echo '<pre style="background-color: #191919;color: #cccccc;padding: 1rem;margin: 1rem;">';
    var_dump($expression);
    echo '</pre>';
    // exit();
}

// Example
// _var_dump($_SERVER);
// _var_dump(__FILE__);
// _var_dump(__DIR__);


/**
 * 
 * Display array information with
 * proper formating using `print_r()`
 * 
 * @param expression $expression
 * 
 * @return null
 */

function _print_r($expression)
{
    echo '<pre style="background-color: #191919;color: #cccccc;padding: 1rem;margin: 1rem;">';
    print_r($expression);
    echo '</pre>';
    // exit();
}

// Example
// _print_r([1,2,3,4,true,false,function(){}]);


/**
 * Generate base url
 * and it's return base url
 * depending on APP_NAME
 * in the config.php
 * 
 * Example: http://localhost/MyProject/
 * 
 * @return string formating string URL
 */

function _get_base_url()
{
    return sprintf(
        "%s://%s%s",
        (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== "off") ? "https" : "http",
        $_SERVER['SERVER_NAME'],
        (isset(_CONFIG['APP_NAME']) && !empty(_CONFIG['APP_NAME'])) ? "/" . _CONFIG['APP_NAME'] . "/" : "/"
    );
}

// Example
// _var_dump(_get_base_url()); // http://localhost/MyProject/


/**
 * Generate url
 * and it's return url
 * depending on APP_NAME
 * in the config.php
 * 
 * Example: http://localhost/MyProject/login.php
 * 
 * @return string formating string URL
 */

function _get_url($path = "")
{
    return sprintf(
        "%s%s",
        _get_base_url(),
        (!empty($path)) ? $path : ""
    );
}

// Example
// _var_dump(_get_url("login.php")); // http://localhost/MyProject/login.php


/**
 * Generate Assets URI
 * and it's return Assets URI
 * 
 * Example: http://localhost/MyProject/assets/css/style.css
 * 
 * @param string $filename ""
 * @param string $assets_dir ""
 * 
 * @return string formating string Assets URI
 */

function _get_assets_uri(string $filename = "", string $assets_dir = "")
{
    $assets_url = _get_base_url() . "assets";
    $uri = "";

    $filename = !empty($filename) ? "/" . trim(trim($filename), "/") : "";
    $assets_dir = !empty($assets_dir) ? "/" . trim(trim($assets_dir), "/") : "";

    $uri .= $assets_url . $assets_dir . $filename;

    return $uri;
}

// Examples
// _var_dump(_get_assets_uri()); // http://localhost/MyProject/assets
// _var_dump(_get_assets_uri("script.js")); // http://localhost/MyProject/assets/script.js
// _var_dump(_get_assets_uri("", "js")); // http://localhost/MyProject/assets/js/
// _var_dump(_get_assets_uri("style.css", "css")); // http://localhost/MyProject/assets/css/style.css
// _var_dump(_get_assets_uri("script.js", "js/base/")); // http://localhost/MyProject/assets/js/base/script.js




/**
 * If Remember me cookie found
 */

function remember_me_loggedin()
{
    $user = null;

    if (isset($_COOKIE['email']) && !empty($_COOKIE['email']) && isset($_COOKIE['utype']) && !empty($_COOKIE['utype'])) {
        if ($_COOKIE['utype'] === 'admin') {
            require_once _ROOT_DIR . "models/Admin/AdminModel.php";

            $user = AdminModel::getUserByEmail($_COOKIE['email']);
            // _var_dump($user);
        } else if ($_COOKIE['utype'] === 'doctor') {
            require_once _ROOT_DIR . "models/Doctor/DoctorModel.php";

            $user = DoctorModel::getUserByEmail($_COOKIE['email']);
        } else if ($_COOKIE['utype'] === 'emanager') {
            require_once _ROOT_DIR . "models/Emanager/EmanagerModel.php";

            $user = EmanagerModel::getUserByEmail($_COOKIE['email']);
        } else if ($_COOKIE['utype'] === 'patient') {
            require_once _ROOT_DIR . "models/Patient/PatientModel.php";

            $user = PatientModel::getUserByEmail($_COOKIE['email']);
        }
    }

    // Login auto if user found
    if ($user) {

        switch ($_COOKIE['utype']) {
            case "admin":

                // Admin Login

                // _var_dump($user);
                // _print_r($user);
                // exit();

                _set_session_val('id', $user['a_id']);
                _set_session_val('uid', $user['u_id']);
                _set_session_val('name', $user['a_name']);
                _set_session_val('email', $user['a_email']);
                _set_session_val('phone', $user['a_phone']);
                _set_session_val('password', $user['a_password']);
                _set_session_val('gender', $user['a_gender']);
                _set_session_val('dob', $user['a_dob']);
                _set_session_val('utype', $user['utype']);
                _set_session_val('pp_path', $user['a_pp_path']);

                _set_logged_in(true);

                break;

            case "doctor":

                // Doctor Login

                // _var_dump($user);
                // _print_r($user);
                // exit();

                if ($user['d_verify'] === 1) {

                    _set_session_val('id', $user['d_id']);
                    _set_session_val('uid', $user['u_id']);
                    _set_session_val('adid', $user['ad_id']);
                    _set_session_val('name', $user['d_name']);
                    _set_session_val('email', $user['d_email']);
                    _set_session_val('phone', $user['d_phone']);
                    _set_session_val('password', $user['d_password']);
                    _set_session_val('gender', $user['d_gender']);
                    _set_session_val('dob', $user['d_dob']);
                    _set_session_val('utype', $user['utype']);
                    _set_session_val('pp_path', $user['d_pp_path']);

                    _set_session_val('degree', $user['d_degree']);
                    _set_session_val('specialization', $user['d_specialization']);
                    _set_session_val('schedule', $user['d_schedule']);
                    _set_session_val('verify', $user['d_verify']);

                    _set_session_val('area', $user['d_area']);
                    _set_session_val('subdistrict', $user['d_subdistrict']);
                    _set_session_val('district', $user['d_district']);
                    _set_session_val('division', $user['d_division']);

                    _set_logged_in(true);
                }


                break;

            case "emanager":

                // Emergency Manager Login

                // _var_dump($user);
                // _print_r($user);
                // exit();

                _set_session_val('id', $user['em_id']);
                _set_session_val('uid', $user['u_id']);
                _set_session_val('aid', $user['ad_id']);
                _set_session_val('name', $user['em_name']);
                _set_session_val('email', $user['em_email']);
                _set_session_val('phone', $user['em_phone']);
                _set_session_val('password', $user['em_password']);
                _set_session_val('gender', $user['em_gender']);
                _set_session_val('dob', $user['em_dob']);
                _set_session_val('utype', $user['utype']);
                _set_session_val('pp_path', $user['em_pp_path']);

                _set_session_val('work_subdistrict', $user['em_work_subdistrict']);

                _set_session_val('area', $user['em_area']);
                _set_session_val('subdistrict', $user['em_subdistrict']);
                _set_session_val('district', $user['em_district']);
                _set_session_val('division', $user['em_division']);

                _set_logged_in(true);

                break;

            case "patient":

                // Patient Login

                // _var_dump($user);
                // _print_r($user);
                // exit();

                _set_session_val('id', $user['p_id']);
                _set_session_val('uid', $user['u_id']);
                _set_session_val('adid', $user['ad_id']);
                _set_session_val('name', $user['p_name']);
                _set_session_val('email', $user['p_email']);
                _set_session_val('phone', $user['p_phone']);
                _set_session_val('password', $user['p_password']);
                _set_session_val('gender', $user['p_gender']);
                _set_session_val('dob', $user['p_dob']);
                _set_session_val('utype', $user['utype']);
                _set_session_val('pp_path', $user['p_pp_path']);

                _set_session_val('area', $user['p_area']);
                _set_session_val('subdistrict', $user['p_subdistrict']);
                _set_session_val('district', $user['p_district']);
                _set_session_val('division', $user['p_division']);

                _set_logged_in(true);

                break;

            default:

                // Default
                $user = null;

                // _set_logged_in(false);

                break;
        }
    }
}

// Auto Login if remember me data found in cookies

remember_me_loggedin();

function _get_messages()
{
    if (_get_session_val('messages')) {
        return _get_session_val('messages');
    }

    $messages = [
        "success" => "",
        "usuccess" => "",
        "errors" => [],
        "data" => [],
    ];

    _set_session_val('messages', $messages);

    return _get_session_val('messages');
}

function _reset_messages_session()
{
    $messages = [
        "success" => "",
        "usuccess" => "",
        "errors" => [],
        "data" => [],
    ];

    _set_session_val('messages', $messages);
}

function _get_messages_errors($value)
{
    $messages = _get_messages();

    if (isset($messages['errors'][$value])) {
        return $messages['errors'][$value];
    }

    return false;
}

function _get_messages_data($value)
{
    $messages = _get_messages();

    if (isset($messages['data'][$value])) {
        return $messages['data'][$value];
    }

    return false;
}

function _get_messages_css_class_name($value)
{
    if (_get_messages_errors($value)) {
        return " is-invalid";
    } else {
        if (_get_messages_data($value)) {
            return " is-valid";
        } else {
            return "";
        }
    }
}

function _active_page($file_name)
{
    // _var_dump(basename($_SERVER['REQUEST_URI']));
    // _var_dump(basename("/"));
    return basename($_SERVER['SCRIPT_FILENAME']) === $file_name;
}

// _print_r($_SERVER);
// _var_dump();
// _var_dump(basename($_SERVER['REQUEST_URI']));

function _success_unsuccess_messages()
{
    $messages = _get_messages();

    if (isset($messages['unsuccess']) && !empty($messages['unsuccess'])) {
?>

        <div class="alert alert-danger d-flex align-items-center" role="alert">
            <i class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2"></i>
            <div>
                <strong><?php echo $messages['unsuccess']; ?></strong>
            </div>
        </div>

    <?php

    }

    if (isset($messages['success']) && !empty($messages['success'])) {
    ?>

        <div class="alert alert-success d-flex align-items-center" role="alert">
            <i class="bi bi-check-circle-fill flex-shrink-0 me-2"></i>
            <div>
                <strong><?php echo $messages['success']; ?></strong>
            </div>
        </div>

<?php

    }
}

function get_expire_time()
{
    // $time_second = (($_COOKIE['expire'] - time()) / (60)) - 5 * 24 * 60;
    $time_second = (($_COOKIE['expire'] - time()) / (60));
    if($time_second > (60 * 24)){
        return round($time_second / (60 * 24)) . " days";
    } else if($time_second < (60 * 24)) {
        return round($time_second / 60) . " hours";
    }
    return $time_second;
}
