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
    $_hospital = null;
    $hospital = null;

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
        $_hospital = EmanagerModel::getHospitalById($id);

        $hospital = [
            "id" => $_hospital['h_id'],
            "name" => $_hospital['h_name'],
            "email" => $_hospital['h_email'],
            "phone" => $_hospital['h_phone'],
            "area" => $_hospital['h_area'],
            "subdistrict" => $_hospital['h_subdistrict'],
            "district" => $_hospital['h_district'],
            "division" => $_hospital['h_division']
        ];

        if ($_hospital) {
            // _var_dump($hospital);
            // exit();
        } else {
            header("Location: " . _get_url("users/emanager/view-hospitals.php"));
            exit();
        }
    } else {
        header("Location: " . _get_url("users/emanager/view-hospitals.php"));
        exit();
    }
} else {
    header("Location: " . _get_url("users/emanager/view-hospitals.php"));
    exit();
}

?>

<?php header_section("EMS | Edit Hospital"); ?>

<main class="container py-2 my-3 border">
    <div class="row">
        <div class="col-12">
            <h1 class="text-center">Edit Hospital</h1>
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

                <form id="edit-hospital-form" action="<?php echo _get_url("controllers/EditHospitalController.php"); ?>" method="POST" class="need-validation">
                    <input type="hidden" name="_id" value="<?php echo $hospital['id']; ?>">
                    <input type="hidden" name="_email" value="<?php echo $hospital['email']; ?>">
                    <div class="row">
                        <div class="row mb-3 has-validation">
                            <label for="name" class="col-sm-3 col-form-label">Name</label>
                            <div class="col-sm-9">
                                <input id="name" type="text" name="name" class="form-control<?php echo _get_messages_css_class_name('name'); ?>" value="<?php echo $hospital['name']; ?>" placeholder="Sasuke Uchiha" onkeyup="validate_name(this);">

                                <div class="invalid-feedback"><?php echo _get_messages_errors('name'); ?></div>
                            </div>
                        </div>
                        <div class="row mb-3 has-validation">
                            <label for="email" class="col-sm-3 col-form-label">Email</label>
                            <div class="col-sm-9">
                                <input id="email" type="text" name="email" class="form-control<?php echo _get_messages_css_class_name('email'); ?>" value="<?php echo $hospital['email']; ?>" placeholder="sasuke@uchiha.com" onkeyup="validate_email(this);">

                                <div class="invalid-feedback"><?php echo _get_messages_errors('email'); ?></div>
                            </div>
                        </div>
                        <div class="row mb-3 has-validation">
                            <label for="phone" class="col-sm-3 col-form-label">Phone</label>
                            <div class="col-sm-9">
                                <input id="phone" type="text" name="phone" class="form-control<?php echo _get_messages_css_class_name('phone'); ?>" value="<?php echo $hospital['phone']; ?>" placeholder="+88016xxxxxxxx" onkeyup="validate_phoneNumber(this);">

                                <div class="invalid-feedback"><?php echo _get_messages_errors('phone'); ?></div>
                            </div>
                        </div>

                        <div class="row mb-3 has-validation">
                            <label for="area" class="col-sm-3 col-form-label">Area</label>
                            <div class="col-sm-9">
                                <input id="area" type="text" name="area" class="form-control<?php echo _get_messages_css_class_name('area'); ?>" value="<?php echo $hospital['area']; ?>" placeholder="e.g Moddho Pikepara" onkeyup="validate_area(this);">

                                <div class="invalid-feedback"><?php echo _get_messages_errors('area'); ?></div>
                            </div>
                        </div>
                        <div class="row mb-3 has-validation">
                            <label for="subdistrict" class="col-sm-3 col-form-label">Sub District</label>
                            <div class="col-sm-9">
                                <input id="subdistrict" type="text" name="subdistrict" class="form-control<?php echo _get_messages_css_class_name('subdistrict'); ?>" value="<?php echo $hospital['subdistrict']; ?>" placeholder="e.g Mirpur" onkeyup="validate_subdistrict(this);">

                                <div class="invalid-feedback"><?php echo _get_messages_errors('subdistrict'); ?></div>
                            </div>
                        </div>
                        <div class="row mb-3 has-validation">
                            <label for="district" class="col-sm-3 col-form-label">District</label>
                            <div class="col-sm-9">
                                <input id="district" type="text" name="district" class="form-control<?php echo _get_messages_css_class_name('district'); ?>" value="<?php echo $hospital['district']; ?>" placeholder="e.g Dhaka" onkeyup="validate_district(this);">

                                <div class="invalid-feedback"><?php echo _get_messages_errors('district'); ?></div>
                            </div>
                        </div>
                        <div class="row mb-3 has-validation">
                            <label for="division" class="col-sm-3 col-form-label">Division</label>
                            <div class="col-sm-9">
                                <input id="division" type="text" name="division" class="form-control<?php echo _get_messages_css_class_name('division'); ?>" value="<?php echo $hospital['division']; ?>" placeholder="e.g Dhaka" onkeyup="validate_division(this);">

                                <div class="invalid-feedback"><?php echo _get_messages_errors('division'); ?></div>
                            </div>
                        </div>

                        <div class="row mb-3 has-validation">
                            <div class="col-sm-3 mb-3 text-sm-end"></div>
                            <div class="col-sm-3 mb-3 text-sm-start">
                                <button id="edit-hospital-btn" type="submit" name="edit-hospital" class="btn btn-success">Edit Hospital</button>
                            </div>
                        </div>
                    </div>
                </form>

            </div>

        </div>
    </div>
</main>

<?php footer_section(); ?>