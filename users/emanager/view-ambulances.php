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

if (_get_session_val('utype') != "emanager") {
    header("Location: " . _get_url("dashboard/dashboard.php"));
    exit();
}

$ambulances = [];

if (_get_messages_data('ambulances') !== false) {
    $ambulances = _get_messages_data('ambulances');
} else {
    $messages = _get_messages();
    $messages['data']['ambulances'] = false;
    _set_session_val("messages", $messages);
}

if (_get_messages_data('ambulances') === false) {
    require_once _ROOT_DIR . "models/Emanager/EmanagerModel.php";

    $ambulances = EmanagerModel::getAllAmbulances();
}

?>

<?php header_section("EMS | View Ambulances"); ?>

<main class="container py-2 my-3 border">
    <div class="row">
        <div class="col-12">
            <h1 class="text-center">View Ambulances</h1>
        </div>
    </div>

    <hr>

    <div class="row d-flex justify-content-center align-items-center">
        <div class="row">

            <?php if (_get_is_logged_in()) side_menu(); ?>

            <div class="col-md-<?php echo _get_is_logged_in() ? "9" : "12"; ?>">

                <form id="view-ambulance-form" action="<?php echo _get_url("controllers/ViewAmbulancesController.php"); ?>" method="POST" class="need-validation">
                    <div class="row">
                        <div class="col-12 col-md-4 mb-3 has-validation">
                            <input type="text" name="area" class="form-control<?php echo _get_messages_css_class_name('area'); ?>" value="<?php echo _get_messages_data('area'); ?>" placeholder="e.g Moddho Pikepara">

                            <div class="invalid-feedback"><?php echo _get_messages_errors('area'); ?></div>
                        </div>
                        <div class="col-12 col-md-4 mb-3 has-validation">
                            <input type="text" name="phone" class="form-control<?php echo _get_messages_css_class_name('phone'); ?>" value="<?php echo _get_messages_data('phone'); ?>" placeholder="+88016xxxxxxxx">

                            <div class="invalid-feedback"><?php echo _get_messages_errors('phone'); ?></div>
                        </div>
                        <div class="col-12 col-md-4 mb-3">
                            <input type="submit" name="viewambulances" class="form-control btn btn-success" value="Search">
                        </div>
                    </div>
                </form>

                <hr>

                <div class="d-flex justify-content-center align-items-center">
                    <div class="table-responsive">
                        <table class="table table-<?php echo _CONFIG['THEME_COLOR']; ?> table-striped">

                            <?php if (count($ambulances) > 0) : ?>

                                <thead>
                                    <tr>
                                        <th scope="col">Phone</th>
                                        <th scope="col">Area</th>
                                        <th scope="col">Sub District</th>
                                        <th scope="col">District</th>
                                        <th scope="col">Division</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>

                            <?php endif; ?>

                            <tbody>

                                <?php foreach ($ambulances as $ambulance) : ?>

                                    <tr>
                                        <td><?php echo $ambulance['am_phone']; ?></td>
                                        <td><?php echo $ambulance['am_area']; ?></td>
                                        <td><?php echo $ambulance['am_subdistrict']; ?></td>
                                        <td><?php echo $ambulance['am_district']; ?></td>
                                        <td><?php echo $ambulance['am_division']; ?></td>
                                        <td class="text-center">
                                            <a href="<?php echo _get_url("controllers/DeleteAmbulanceController.php?id=" . urlencode($ambulance['am_id'])); ?>" class="btn btn-danger mb-3" onclick="confirmDelete(event, this);">Delete</a>
                                            <a href="<?php echo _get_url("users/emanager/edit-ambulance.php?id=" . urlencode($ambulance['am_id'])); ?>" class="btn btn-success mb-3">Edit</a>
                                        </td>
                                    </tr>

                                <?php endforeach; ?>

                                <?php if (count($ambulances) == 0) : ?>

                                    <tr class="text-center">
                                        <td colspan="6">No Ambulances Found</td>
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