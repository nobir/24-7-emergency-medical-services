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

require_once _ROOT_DIR . "models/Admin/AdminModel.php";
$doctors = AdminModel::getAllUnverifiedDoctors();

?>

<?php header_section("EMS | Verify Doctors"); ?>

<main class="container py-2 my-3 border">
    <div class="row">
        <div class="col-12">
            <h1 class="text-center">Verify Doctor</h1>
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
                <div class="d-flex justify-content-center align-items-center">
                    <div class="table-responsive">
                        <table class="table table-<?php echo _CONFIG['THEME_COLOR']; ?> table-striped">

                            <?php if (count($doctors) > 0) : ?>

                                <thead>
                                    <tr>
                                        <th scope="col">Name</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Phone</th>
                                        <th scope="col">Gender</th>
                                        <th scope="col">Dob</th>
                                        <th scope="col">Type</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>

                            <?php endif; ?>

                            <tbody>

                                <?php foreach ($doctors as $doctor) : ?>

                                    <tr>
                                        <td><?php echo $doctor['d_name']; ?></td>
                                        <td><?php echo $doctor['d_email']; ?></td>
                                        <td><?php echo $doctor['d_phone']; ?></td>
                                        <td><?php echo ucfirst($doctor['d_gender']); ?></td>
                                        <td><?php echo date("d/m/Y", strtotime($doctor['d_dob'])); ?></td>
                                        <td><?php echo $doctor['utype']; ?></td>
                                        <td>
                                            <a href="<?php echo _get_url("controllers/VerifyDoctorController.php?d_id=" . urlencode($doctor['d_id'])); ?>" class="btn btn-success">Verify</a>
                                        </td>
                                    </tr>

                                <?php endforeach; ?>

                                <?php if (count($doctors) == 0) : ?>

                                    <tr class="text-center">
                                        <td colspan="6">No Doctors to verify</td>
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