<?php

/**
 * Can access direcly by URL
 */

define("_DIRECT_ACCESS", true);

require_once dirname(__FILE__, 2) . "/helper/functions.php";

if (!_get_is_logged_in()) {
    header("Location: " . _get_url("login.php"));
    exit();
}

?>

<?php header_section("EMS | Change Password"); ?>

<main class="container py-2 my-3 border">
    <div class="row">
        <div class="col-12">
            <h1 class="text-center">Change Password</h1>
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

                <form id="change-password-form" action="<?php echo _get_url("controllers/ChangePasswordController.php"); ?>" method="post" class="needs-validation">
                    <div class="row mb-3 has-validation">
                        <label for="currentpass" class="col-sm-3 col-form-label">Current Password</label>
                        <div class="col-sm-9">
                            <input id="currentpass" type="password" name="currentpass" class="form-control<?php echo _get_messages_css_class_name('currentpass'); ?>" value="<?php echo _get_messages_data('currentpass'); ?>" onkeyup="validate_currentpass(this);">

                            <div class="invalid-feedback"><?php echo _get_messages_errors('currentpass'); ?></div>
                        </div>
                    </div>
                    <div class="row mb-3 has-validation">
                        <label for="newpass" class="col-sm-3 col-form-label">New Password</label>
                        <div class="col-sm-9">
                            <input id="newpass" type="password" name="newpass" class="form-control<?php echo _get_messages_css_class_name('newpass'); ?>" value="<?php echo _get_messages_data('newpass'); ?>" onkeyup="validate_newpass(this);">

                            <div class="invalid-feedback"><?php echo _get_messages_errors('newpass'); ?></div>
                        </div>
                    </div>
                    <div class="row mb-3 has-validation">
                        <label for="retypepass" class="col-sm-3 col-form-label">Retype Password</label>
                        <div class="col-sm-9">
                            <input id="retypepass" type="password" name="retypepass" class="form-control<?php echo _get_messages_css_class_name('retypepass'); ?>" value="<?php echo _get_messages_data('retypepass'); ?>" onkeyup="validate_retypepass(this);">

                            <div class="invalid-feedback"><?php echo _get_messages_errors('retypepass'); ?></div>
                        </div>
                    </div>
                    <div class="row mb-3 has-validation">
                        <div class="col-sm-3 mb-3 text-sm-end">
                            <button id="reset-btn" type="reset" class="btn btn-success">Reset</button>
                        </div>
                        <div class="col-sm-3 mb-3 text-sm-start">
                            <button id="change-password-btn" type="submit" name="changepassword" class="btn btn-success">Change</button>
                        </div>
                    </div>
                </form>

            </div>

        </div>
    </div>
</main>

<?php footer_section(); ?>