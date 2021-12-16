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

if (_get_session_val('utype') != "doctor") {
    header("Location: " . _get_url("dashboard/dashboard.php"));
    exit();
}

// $appointments = isset($messages['data']['appointments']) ? $messages['data']['appointments'] : [];

// if(!isset($messages['data']['appointments']) && empty($appointments)) {
//     // require_once _ROOT_DIR . "model/UserModel.php";

//     // $appointments = _view_appointments();
// }

$appointments = [];

if (_get_messages_data('appointments') !== false) {
    $appointments = _get_messages_data('appointments');
} else {
    $messages = _get_messages();
    $messages['data']['appointments'] = false;
    _set_session_val("messages", $messages);
}

if (_get_messages_data('appointments') === false) {
    require_once _ROOT_DIR . "models/Doctor/DoctorModel.php";

    $appointments = DoctorModel::getAllAppointments(_get_session_val("id"));
}

?>

<?php header_section("EMS | View Appointments"); ?>

<main class="container py-2 my-3 border">
    <div class="row">
        <div class="col-12">
            <h1 class="text-center">View Appointments</h1>
        </div>
    </div>

    <hr>

    <div class="row d-flex justify-content-center align-items-center">
        <div class="row">

            <?php if (_get_is_logged_in()) side_menu(); ?>

            <div class="col-md-<?php echo _get_is_logged_in() ? "9" : "12"; ?>">

                <form id="view-doctor-form" action="<?php echo _get_url("controllers/ViewAppointmentsController.php"); ?>" method="POST" class="need-validation" onkeyup="searchAppointment(event, this);">
                    <div class="row">
                        <div class="col-12 col-md-4 mb-3">
                            <input type="text" name="name" class="form-control" value="<?php echo _get_messages_data('name'); ?>" placeholder="Name...">
                        </div>
                        <div class="col-12 col-md-4 mb-3 has-validation">
                            <input type="text" name="email" class="form-control<?php echo _get_messages_css_class_name('email'); ?>" value="<?php echo _get_messages_data('email'); ?>" placeholder="Email..">

                            <div class="invalid-feedback"><?php echo _get_messages_errors('email'); ?></div>
                        </div>
                        <div class="col-12 col-md-4 mb-3">
                            <input type="submit" name="viewappointments" class="form-control btn btn-success" value="Search">
                        </div>
                    </div>
                </form>

                <hr>

                <div class="d-flex justify-content-center align-items-center">
                    <div class="table-responsive">
                        <table class="table table-<?php echo _CONFIG['THEME_COLOR']; ?> table-striped">

                            <?php if (count($appointments) > 0) : ?>

                                <thead>
                                    <tr>
                                        <th scope="col">Patient Name</th>
                                        <th scope="col">Patient Email</th>
                                        <th scope="col">Patient Phone</th>
                                        <th scope="col">Reason</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>

                            <?php endif; ?>

                            <tbody id="appointments-data">

                                <?php foreach ($appointments as $appointment) : ?>

                                    <tr>
                                        <td><?php echo $appointment['p_name']; ?></td>
                                        <td><?php echo $appointment['p_email']; ?></td>
                                        <td><?php echo $appointment['p_phone']; ?></td>
                                        <td><?php echo $appointment['ap_reason']; ?></td>
                                        <td class="text-center">
                                            <a href="<?php echo _get_url("controllers/RejectAppointmentController.php?id=" . urlencode($appointment['ap_id'])); ?>" class="btn btn-danger mb-3" onclick="confirmReject(event, this);">Reject</a>
                                            <a href="<?php echo _get_url("controllers/AcceptAppointmentController.php?id=" . urlencode($appointment['ap_id'])); ?>" class="btn btn-success mb-3">Accept</a>
                                        </td>
                                    </tr>

                                <?php endforeach; ?>

                                <?php if (count($appointments) == 0) : ?>

                                    <tr class="text-center">
                                        <td colspan="6">No Appointments Found</td>
                                    </tr>

                                <?php endif; ?>

                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

        </div>
    </div>
</main>

<?php footer_section(); ?>