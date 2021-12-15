<?php

/**
 * Can access direcly by URL
 */

define("_DIRECT_ACCESS", true);

?>

<?php require_once dirname(dirname(dirname(__FILE__))) . "/helper/functions.php"; ?>

<?php

if (!_get_is_logged_in()) {
    header("Location: " . _get_url("login.php"));
    exit();
}

if (_get_session_val('utype') != "patient") {
    header("Location: " . _get_url("dashboard/dashboard.php"));
    exit();
}

?>

<?php header_section("EMS | Request Appointment"); ?>

<main class="container py-2 my-3 border">
    <div class="row">
        <div class="col-12">
            <h1 class="text-center">Request Appointment</h1>
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

                <form id="request-appointment-form" action="<?php echo _get_url("controllers/AppointmentController.php"); ?>" method="POST" class="need-validation">
                    <div class="row">
                        <div class="row mb-3 has-validation">
                            <label for="docemail" class="col-sm-3 col-form-label">Doctor Email</label>
                            <div class="col-sm-9">
                                <input id="docemail" type="text" name="docemail" class="form-control<?php echo _get_messages_css_class_name('docemail'); ?>" value="<?php echo _get_messages_data('docemail'); ?>" placeholder="sasuke@uchiha.com" onkeyup="validate_email(this);">

                                <div class="invalid-feedback"><?php echo _get_messages_errors('docemail'); ?></div>
                            </div>
                        </div>
                        <div class="row mb-3 has-validation">
                            <label for="reason" class="col-sm-3 col-form-label">Reason</label>
                            <div class="col-sm-9">
                                <input id="reason" type="text" name="reason" class="form-control<?php echo _get_messages_css_class_name('reason'); ?>" value="<?php echo _get_messages_data('reason'); ?>" placeholder="Heart problem" onkeyup="validate_name(this);">

                                <div class="invalid-feedback"><?php echo _get_messages_errors('reason'); ?></div>
                            </div>
                        </div>
                        <div class="row mb-3 has-validation">
                            <div class="col-sm-3 mb-3 text-sm-end"></div>
                            <div class="col-sm-3 mb-3 text-sm-start">
                                <button id="appointment-btn" type="submit" name="appointment" class="btn btn-success">Request Appointment</button>
                            </div>
                        </div>
                    </div>
                </form>

            </div>

        </div>
    </div>
</main>

<?php footer_section(); ?>