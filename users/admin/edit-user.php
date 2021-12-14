<?php

/**
 * Can access direcly by URL
 */

define("_DIRECT_ACCESS", true);

?>

<?php require_once dirname(__FILE__, 3) . "/helper/functions.php"; ?>

<?php

if (!_get_is_logged_in()) {
    header("Location: " . _get_url("login.php"));
    exit();
}

if (_get_session_val('utype') != "admin") {
    header("Location: " . _get_url("dashboard/index.php"));
    exit();
}

require_once _ROOT_DIR . "controllers/ValidationController.php";

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
    $_user = null;
    $user = null;

    // Email
    _validate_email_login($email, $_GET['email'], $messages, $has_err);

    // User type
    _validate_utype_login($utype, $_GET['utype'], $messages, $has_err);

    if (!$has_err) {
        switch ($utype) {
            case 'admin':
                // Edit Admin
                require_once _ROOT_DIR . "models/Admin/AdminModel.php";
                $_user = AdminModel::getUserByEmail($email);

                $user = [
                    "id" => $_user['a_id'],
                    "name" => $_user['a_name'],
                    "email" => $_user['a_email'],
                    "phone" => $_user['a_phone'],
                    "gender" => $_user['a_gender'],
                    "dob" => $_user['a_dob'],
                    "utype" => $_user['utype']
                ];

                break;

            case 'doctor':
                // Edit Doctor
                require_once _ROOT_DIR . "models/Doctor/DoctorModel.php";
                $_user = DoctorModel::getUserByEmail($email);

                $user = [
                    "id" => $_user['d_id'],
                    "name" => $_user['d_name'],
                    "email" => $_user['d_email'],
                    "phone" => $_user['d_phone'],
                    "gender" => $_user['d_gender'],
                    "dob" => $_user['d_dob'],
                    "utype" => $_user['utype'],

                    "degree" => $_user['d_degree'],
                    "specialization" => $_user['d_specialization'],
                    "schedule" => $_user['d_schedule'],

                    "area" => $_user['d_area'],
                    "subdistrict" => $_user['d_subdistrict'],
                    "district" => $_user['d_district'],
                    "division" => $_user['d_division'],
                ];

                break;

            case 'emanager':
                // Edit Emanager
                require_once _ROOT_DIR . "models/Emanager/EmanagerModel.php";
                $_user = EmanagerModel::getUserByEmail($email);

                $user = [
                    "id" => $_user['em_id'],
                    "name" => $_user['em_name'],
                    "email" => $_user['em_email'],
                    "phone" => $_user['em_phone'],
                    "gender" => $_user['em_gender'],
                    "dob" => $_user['em_dob'],
                    "utype" => $_user['utype'],

                    "work_subdistrict" => $_user['em_work_subdistrict'],

                    "area" => $_user['em_area'],
                    "subdistrict" => $_user['em_subdistrict'],
                    "district" => $_user['em_district'],
                    "division" => $_user['em_division'],
                ];

                break;

            case 'patient':
                // Edit Patient
                require_once _ROOT_DIR . "models/Patient/PatientModel.php";
                $_user = PatientModel::getUserByEmail($email);

                $user = [
                    "id" => $_user['p_id'],
                    "name" => $_user['p_name'],
                    "email" => $_user['p_email'],
                    "phone" => $_user['p_phone'],
                    "gender" => $_user['p_gender'],
                    "dob" => $_user['p_dob'],
                    "utype" => $_user['utype'],

                    "area" => $_user['p_area'],
                    "subdistrict" => $_user['p_subdistrict'],
                    "district" => $_user['p_district'],
                    "division" => $_user['p_division'],
                ];

                break;

            default:
                $_user = null;
                break;
        }

        if ($_user) {
            // _var_dump($user);
            // exit();
        } else {
            header("Location: " . _get_url("users/admin/view-users.php"));
            exit();
        }
    } else {
        header("Location: " . _get_url("users/admin/view-users.php"));
        exit();
    }
} else {
    header("Location: " . _get_url("users/admin/view-users.php"));
    exit();
}

?>

<?php header_section("EMS | Edit User"); ?>

<main class="container py-2 my-3 border">
    <div class="row">
        <div class="col-12">
            <h1 class="text-center">Edit User</h1>
        </div>
    </div>

    <hr>

    <div class="row d-flex justify-content-center align-items-center">
        <div class="row">

            <?php if (_get_is_logged_in()) side_menu(); ?>

            <div class="col-md-<?php echo _get_is_logged_in() ? "9" : "12"; ?>">
                <div class="">

                    <?php _success_unsuccess_messages(); ?>

                </div>

                <form id="edit-profile-form" action="<?php echo _get_url("controllers/EditUserProfileController.php"); ?>" method="post" class="needs-validation">
                    <input type="hidden" name="_id" value="<?php echo $user['id']; ?>">
                    <input type="hidden" name="_email" value="<?php echo $email; ?>">
                    <input type="hidden" name="_utype" value="<?php echo $utype; ?>">
                    <div class="row mb-3 has-validation">
                        <label for="name" class="col-sm-3 col-form-label">Name</label>
                        <div class="col-sm-9">
                            <input id="name" type="text" name="name" class="form-control<?php echo _get_messages_css_class_name('name'); ?>" value="<?php echo $user['name']; ?>" placeholder="Sasuke Uchiha">

                            <?php if (_get_messages_errors('name')) : ?><div class="invalid-feedback"><?php echo _get_messages_errors('name'); ?></div><?php endif; ?>
                        </div>
                    </div>
                    <div class="row mb-3 has-validation">
                        <label for="email" class="col-sm-3 col-form-label">Email</label>
                        <div class="col-sm-9">
                            <input id="email" type="text" name="email" class="form-control<?php echo _get_messages_css_class_name('email'); ?>" value="<?php echo $user['email']; ?>" placeholder="sasuke@uchiha.com">

                            <?php if (_get_messages_errors('email')) : ?><div class="invalid-feedback"><?php echo _get_messages_errors('email'); ?></div><?php endif; ?>
                        </div>
                    </div>
                    <div class="row mb-3 has-validation">
                        <label for="phone" class="col-sm-3 col-form-label">Phone</label>
                        <div class="col-sm-9">
                            <input id="phone" type="text" name="phone" class="form-control<?php echo _get_messages_css_class_name('phone'); ?>" value="<?php echo $user['phone']; ?>" placeholder="+88016xxxxxxxx">

                            <?php if (_get_messages_errors('phone')) : ?><div class="invalid-feedback"><?php echo _get_messages_errors('phone'); ?></div><?php endif; ?>
                        </div>
                    </div>
                    <div class="row mb-3 has-validation">
                        <label for="dob" class="col-sm-3 col-form-label">Date of Birth</label>
                        <div class="col-sm-9">
                            <input id="dob" type="date" name="dob" class="form-control<?php echo _get_messages_css_class_name('dob'); ?>" value="<?php echo $user['dob']; ?>">

                            <?php if (_get_messages_errors('dob')) : ?><div class="invalid-feedback"><?php echo _get_messages_errors('dob'); ?></div><?php endif; ?>
                        </div>
                    </div>
                    <fieldset class="row mb-3">
                        <legend class="col-form-label col-sm-3 pt-0">Gender</legend>
                        <div class="col-sm-9">
                            <div class="form-check">
                                <input id="male" type="radio" name="gender" class="form-check-input<?php echo $user['gender'] === "male" ? " is-valid" : ""; ?>" value="male" <?php echo $user['gender'] === "male" ? " checked" : ""; ?>>
                                <label for="male" class="form-check-label">Male</label>
                            </div>
                            <div class="form-check">
                                <input id="female" type="radio" name="gender" class="form-check-input<?php echo $user['gender'] === "female" ? " is-valid" : ""; ?>" value="female" <?php echo $user['gender'] === "female" ? " checked" : ""; ?>>
                                <label for="female" class="form-check-label">Female</label>
                            </div>
                            <div class="form-check">
                                <input id="other" type="radio" name="gender" class="form-check-input<?php echo $user['gender'] === "other" ? " is-valid" : ""; ?>" value="other" <?php echo $user['gender'] === "other" ? " checked" : ""; ?>>
                                <label for="other" class="form-check-label">Other</label>
                            </div>

                            <input class="<?php echo trim(_get_messages_css_class_name('gender')); ?>" type="hidden">

                            <?php if (_get_messages_errors('gender')) : ?><div class="invalid-feedback"><?php echo _get_messages_errors('gender'); ?></div><?php endif; ?>

                        </div>
                    </fieldset>


                    <!-- Doctor Extra inputs -->

                    <?php if ($utype === 'doctor') : ?>

                        <div class="row mb-3 has-validation">
                            <label for="degree" class="col-sm-3 col-form-label">Degree</label>
                            <div class="col-sm-9">
                                <input id="degree" type="text" name="degree" class="form-control<?php echo _get_messages_css_class_name('degree'); ?>" value="<?php echo $user['degree']; ?>" placeholder="e.g Moddho Pikepara">

                                <?php if (_get_messages_errors('degree')) : ?><div class="invalid-feedback"><?php echo _get_messages_errors('degree'); ?></div><?php endif; ?>
                            </div>
                        </div>

                    <?php endif; ?>

                    <?php if ($utype === 'doctor') : ?>

                        <div class="row mb-3 has-validation">
                            <label for="specialization" class="col-sm-3 col-form-label">Specialization</label>
                            <div class="col-sm-9">
                                <input id="specialization" type="text" name="specialization" class="form-control<?php echo _get_messages_css_class_name('specialization'); ?>" value="<?php echo $user['specialization']; ?>" placeholder="e.g Moddho Pikepara">

                                <?php if (_get_messages_errors('specialization')) : ?><div class="invalid-feedback"><?php echo _get_messages_errors('specialization'); ?></div><?php endif; ?>
                            </div>
                        </div>

                    <?php endif; ?>

                    <?php if ($utype === 'doctor') : ?>

                        <div class="row mb-3 has-validation">
                            <label for="schedule" class="col-sm-3 col-form-label">Schedule</label>
                            <div class="col-sm-9">
                                <input id="schedule" type="text" name="schedule" class="form-control<?php echo _get_messages_css_class_name('schedule'); ?>" value="<?php echo $user['schedule']; ?>" placeholder="e.g Moddho Pikepara">

                                <?php if (_get_messages_errors('schedule')) : ?><div class="invalid-feedback"><?php echo _get_messages_errors('schedule'); ?></div><?php endif; ?>
                            </div>
                        </div>

                    <?php endif; ?>

                    <!-- Doctor END -->

                    <!-- Emanager Extra inputs -->

                    <?php if ($utype === 'emanager') : ?>

                        <div class="row mb-3 has-validation">
                            <label for="work_subdistrict" class="col-sm-3 col-form-label">Work Sub District</label>
                            <div class="col-sm-9">
                                <input id="work_subdistrict" type="text" name="work_subdistrict" class="form-control<?php echo _get_messages_css_class_name('work_subdistrict'); ?>" value="<?php echo $user['work_subdistrict']; ?>" placeholder="e.g Mirpur">

                                <?php if (_get_messages_errors('work_subdistrict')) : ?><div class="invalid-feedback"><?php echo _get_messages_errors('work_subdistrict'); ?></div><?php endif; ?>
                            </div>
                        </div>

                    <?php endif; ?>

                    <?php if ($utype === 'emanager' || $utype === 'doctor' || $utype === 'patient') : ?>

                        <div class="row mb-3 has-validation">
                            <label for="area" class="col-sm-3 col-form-label">Area</label>
                            <div class="col-sm-9">
                                <input id="area" type="text" name="area" class="form-control<?php echo _get_messages_css_class_name('area'); ?>" value="<?php echo $user['area']; ?>" placeholder="e.g Moddho Pikepara">

                                <?php if (_get_messages_errors('area')) : ?><div class="invalid-feedback"><?php echo _get_messages_errors('area'); ?></div><?php endif; ?>
                            </div>
                        </div>
                        <div class="row mb-3 has-validation">
                            <label for="subdistrict" class="col-sm-3 col-form-label">Sub District</label>
                            <div class="col-sm-9">
                                <input id="subdistrict" type="text" name="subdistrict" class="form-control<?php echo _get_messages_css_class_name('subdistrict'); ?>" value="<?php echo $user['subdistrict']; ?>" placeholder="e.g Mirpur">

                                <?php if (_get_messages_errors('subdistrict')) : ?><div class="invalid-feedback"><?php echo _get_messages_errors('subdistrict'); ?></div><?php endif; ?>
                            </div>
                        </div>
                        <div class="row mb-3 has-validation">
                            <label for="district" class="col-sm-3 col-form-label">District</label>
                            <div class="col-sm-9">
                                <input id="district" type="text" name="district" class="form-control<?php echo _get_messages_css_class_name('district'); ?>" value="<?php echo $user['district']; ?>" placeholder="e.g Dhaka">

                                <?php if (_get_messages_errors('district')) : ?><div class="invalid-feedback"><?php echo _get_messages_errors('district'); ?></div><?php endif; ?>
                            </div>
                        </div>
                        <div class="row mb-3 has-validation">
                            <label for="division" class="col-sm-3 col-form-label">Division</label>
                            <div class="col-sm-9">
                                <input id="division" type="text" name="division" class="form-control<?php echo _get_messages_css_class_name('division'); ?>" value="<?php echo $user['division']; ?>" placeholder="e.g Dhaka">

                                <?php if (_get_messages_errors('division')) : ?><div class="invalid-feedback"><?php echo _get_messages_errors('division'); ?></div><?php endif; ?>
                            </div>
                        </div>

                    <?php endif; ?>

                    <div class="row mb-3 has-validation">
                        <div class="col-sm-3 mb-3 text-sm-end"></div>
                        <div class="col-sm-3 mb-3 text-sm-start">
                            <button id="edit-profile-btn" type="submit" name="edit-profile" class="btn btn-success">Save</button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</main>

<?php footer_section(); ?>