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

require_once _ROOT_DIR . "controllers/ValidationController.php";

if (isset($_GET['id'])) {

    $has_err = false;
    $is_deleted = false;

    $messages = [
        "unsuccess" => "",
        "success" => "",
        "errors" => [],
        "data" => []
    ];

    $id = "";
    $_ambulance = null;
    $ambulance = null;

    // Id
    if (!is_numeric($_GET['id'])) {
        $messages["errors"]['id'] = "Invalid ID";
        $has_err = true;
    } else {
        $id = validate_input($_GET['id']);
        $messages['data']['id'] = $id;
    }

    if (!$has_err) {

        require_once _ROOT_DIR . "models/Emanager/EmanagerModel.php";
        $_ambulance = EmanagerModel::getAmbulanceById($id);

        $ambulance = [
            "id" => $_ambulance['am_id'],
            "phone" => $_ambulance['am_phone'],
            "area" => $_ambulance['am_area'],
            "subdistrict" => $_ambulance['am_subdistrict'],
            "district" => $_ambulance['am_district'],
            "division" => $_ambulance['am_division']
        ];

        if ($_ambulance) {
            // _var_dump($ambulance);
            // exit();
        } else {
            header("Location: " . _get_url("users/emanager/view-ambulances.php"));
            exit();
        }
    } else {
        header("Location: " . _get_url("users/emanager/view-ambulances.php"));
        exit();
    }
} else {
    header("Location: " . _get_url("users/emanager/view-ambulances.php"));
    exit();
}

?>

<?php header_section("EMS | Edit Ambulance"); ?>

<main class="container py-2 my-3 border">
    <div class="row">
        <div class="col-12">
            <h1 class="text-center">Edit Ambulance</h1>
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

                <form id="add-ambulance-form" action="<?php echo _get_url("controllers/EditAmbulanceController.php"); ?>" method="POST" class="need-validation">
                    <input type="hidden" name="_id" value="<?php echo $ambulance['id']; ?>">
                    <input type="hidden" name="_phone" value="<?php echo $ambulance['phone']; ?>">
                    <div class="row">

                        <div class="row mb-3 has-validation">
                            <label for="phone" class="col-sm-3 col-form-label">Phone</label>
                            <div class="col-sm-9">
                                <input id="phone" type="text" name="phone" class="form-control<?php echo _get_messages_css_class_name('phone'); ?>" value="<?php echo $ambulance['phone']; ?>" placeholder="+88016xxxxxxxx" onkeyup="validate_phoneNumber(this);">

                                <div class="invalid-feedback"><?php echo _get_messages_errors('phone'); ?></div>
                            </div>
                        </div>

                        <div class="row mb-3 has-validation">
                            <label for="area" class="col-sm-3 col-form-label">Area</label>
                            <div class="col-sm-9">
                                <input id="area" type="text" name="area" class="form-control<?php echo _get_messages_css_class_name('area'); ?>" value="<?php echo $ambulance['area']; ?>" placeholder="e.g Moddho Pikepara" onkeyup="validate_area(this);">

                                <div class="invalid-feedback"><?php echo _get_messages_errors('area'); ?></div>
                            </div>
                        </div>
                        <div class="row mb-3 has-validation">
                            <label for="subdistrict" class="col-sm-3 col-form-label">Sub District</label>
                            <div class="col-sm-9">
                                <input id="subdistrict" type="text" name="subdistrict" class="form-control<?php echo _get_messages_css_class_name('subdistrict'); ?>" value="<?php echo $ambulance['subdistrict']; ?>" placeholder="e.g Mirpur" onkeyup="validate_subdistrict(this);">

                                <div class="invalid-feedback"><?php echo _get_messages_errors('subdistrict'); ?></div>
                            </div>
                        </div>
                        <div class="row mb-3 has-validation">
                            <label for="district" class="col-sm-3 col-form-label">District</label>
                            <div class="col-sm-9">
                                <input id="district" type="text" name="district" class="form-control<?php echo _get_messages_css_class_name('district'); ?>" value="<?php echo $ambulance['district']; ?>" placeholder="e.g Dhaka" onkeyup="validate_district(this);">

                                <div class="invalid-feedback"><?php echo _get_messages_errors('district'); ?></div>
                            </div>
                        </div>
                        <div class="row mb-3 has-validation">
                            <label for="division" class="col-sm-3 col-form-label">Division</label>
                            <div class="col-sm-9">
                                <input id="division" type="text" name="division" class="form-control<?php echo _get_messages_css_class_name('division'); ?>" value="<?php echo $ambulance['division']; ?>" placeholder="e.g Dhaka" onkeyup="validate_division(this);">

                                <div class="invalid-feedback"><?php echo _get_messages_errors('division'); ?></div>
                            </div>
                        </div>

                        <div class="row mb-3 has-validation">
                            <div class="col-sm-3 mb-3 text-sm-end"></div>
                            <div class="col-sm-3 mb-3 text-sm-start">
                                <button id="edit-ambulance-btn" type="submit" name="edit-ambulance" class="btn btn-success">Edit Ambulance</button>
                            </div>
                        </div>
                    </div>
                </form>

            </div>

        </div>
    </div>
</main>

<?php footer_section(); ?>