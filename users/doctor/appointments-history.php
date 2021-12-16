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

$appointments = [];

require_once _ROOT_DIR . "models/Doctor/DoctorModel.php";

$appointments = DoctorModel::getAllAppointmentHistopy(_get_session_val("id"));

?>

<?php header_section("EMS | Appointments History"); ?>

<main class="container py-2 my-3 border">
    <div class="row">
        <div class="col-12">
            <h1 class="text-center">Appointments History</h1>
        </div>
    </div>

    <hr>

    <div class="row d-flex justify-content-center align-items-center">
        <div class="row">

            <?php if (_get_is_logged_in()) side_menu(); ?>

            <div class="col-md-<?php echo _get_is_logged_in() ? "9" : "12"; ?>">

                <div class="d-flex justify-content-center align-items-center">
                    <div class="table-responsive w-100">
                        <table class="table table-<?php echo _CONFIG['THEME_COLOR']; ?> table-striped">

                            <?php if (count($appointments) > 0) : ?>

                                <thead>
                                    <tr>
                                        <th scope="col">Patient Name</th>
                                        <th scope="col">Patient Email</th>
                                        <th scope="col">Patient Phone</th>
                                        <th scope="col">Reason</th>
                                    </tr>
                                </thead>

                            <?php endif; ?>

                            <tbody>

                                <?php foreach ($appointments as $appointment) : ?>

                                    <tr class="<?php echo $appointment['ap_status'] == 0 ? "table-danger" : "table-success"; ?>">
                                        <td><?php echo $appointment['p_name']; ?></td>
                                        <td><?php echo $appointment['p_email']; ?></td>
                                        <td><?php echo $appointment['p_phone']; ?></td>
                                        <td><?php echo $appointment['ap_reason']; ?></td>
                                    </tr>

                                <?php endforeach; ?>

                                <?php if (count($appointments) == 0) : ?>

                                    <tr class="text-center">
                                        <td colspan="6">No Appointment History Found</td>
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