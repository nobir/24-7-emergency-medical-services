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

if (_get_session_val('utype') != "patient") {
    header("Location: " . _get_url("dashboard/dashboard.php"));
    exit();
}

$hospitals = [];

if (_get_messages_data('hospitals') !== false) {
    $hospitals = _get_messages_data('hospitals');
} else {
    $messages = _get_messages();
    $messages['data']['hospitals'] = false;
    _set_session_val("messages", $messages);
}

if (_get_messages_data('hospitals') === false) {
    require_once _ROOT_DIR . "models/Patient/PatientModel.php";

    $hospitals = PatientModel::getAllHospitals();
}

?>

<?php header_section("EMS | View Hospitals"); ?>

<main class="container py-2 my-3 border">
    <div class="row">
        <div class="col-12">
            <h1 class="text-center">View Hospitals</h1>
        </div>
    </div>

    <hr>

    <div class="row d-flex justify-content-center align-items-center">
        <div class="row">

            <?php if (_get_is_logged_in()) side_menu(); ?>

            <div class="col-md-<?php echo _get_is_logged_in() ? "9" : "12"; ?>">

                <form id="view-hospital-form" action="<?php echo _get_url("controllers/ViewHospitalsPatientController.php"); ?>" method="POST" class="need-validation">
                    <div class="row">
                        <div class="col-12 col-md-4 mb-3">
                            <input type="text" name="name" class="form-control" value="<?php echo _get_messages_data('name'); ?>" placeholder="Name...">
                        </div>
                        <div class="col-12 col-md-4 mb-3 has-validation">
                            <input type="text" name="email" class="form-control<?php echo _get_messages_css_class_name('email'); ?>" value="<?php echo _get_messages_data('email'); ?>" placeholder="Email..">

                            <?php if (_get_messages_errors('email')) : ?><div class="invalid-feedback"><?php echo _get_messages_errors('email'); ?></div><?php endif; ?>
                        </div>
                        <div class="col-12 col-md-4 mb-3">
                            <input type="submit" name="viewhospitals" class="form-control btn btn-success" value="Search">
                        </div>
                    </div>
                </form>

                <hr>

                <div class="d-flex justify-content-center align-items-center">
                    <div class="table-responsive">
                        <table class="table table-<?php echo _CONFIG['THEME_COLOR']; ?> table-striped">

                            <?php if (count($hospitals) > 0) : ?>

                                <thead>
                                    <tr>
                                        <th scope="col">Name</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Phone</th>
                                        <th scope="col">Area</th>
                                        <th scope="col">Sub District</th>
                                        <th scope="col">District</th>
                                        <th scope="col">Division</th>
                                    </tr>
                                </thead>

                            <?php endif; ?>

                            <tbody>

                                <?php foreach ($hospitals as $hospital) : ?>

                                    <tr>
                                        <td><?php echo $hospital['h_name']; ?></td>
                                        <td><?php echo $hospital['h_email']; ?></td>
                                        <td><?php echo $hospital['h_phone']; ?></td>
                                        <td><?php echo $hospital['h_area']; ?></td>
                                        <td><?php echo $hospital['h_subdistrict']; ?></td>
                                        <td><?php echo $hospital['h_district']; ?></td>
                                        <td><?php echo $hospital['h_division']; ?></td>
                                    </tr>

                                <?php endforeach; ?>

                                <?php if (count($hospitals) == 0) : ?>

                                    <tr class="text-center">
                                        <td colspan="6">No Hospitals Found</td>
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