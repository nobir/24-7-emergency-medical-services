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

// _var_dump($_SESSION);

?>

<?php header_section("EMS | Profile Picture"); ?>

<main class="container py-2 my-3 border">
    <div class="row">
        <div class="col-12">
            <h1 class="text-center">Profile Picture</h1>
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

                <form action="<?php echo _get_url("controllers/ChangeProfilePictureController.php"); ?>" method="POST" enctype="multipart/form-data" class="needs-validation">

                    <div class="mb-3 input-group">
                        <label for="picture" class="col-sm-4 col-form-label"></label>
                        <div class="form-control d-flex justify-content-center align-item-center border-0 mx-1">
                            <img src="<?php echo !empty(_get_session_val('pp_path')) ? _get_assets_uri(_get_session_val('pp_path'), "uploads") : _get_assets_uri("default-pp.png", "img"); ?>" class="img-thumbnail rounded" alt="<?php echo _get_session_val("name");   ?>">
                        </div>
                    </div>
                    <div class="row mb-3 has-validation">
                        <label for="picture" class="col-sm-3 col-form-label">Picture</label>
                        <div class="col-sm-9">

                            <input id="picture" type="file" name="picture" class="form-control<?php echo _get_messages_css_class_name('picture'); ?>" value="<?php echo _get_messages_data('picture'); ?>">

                            <?php if (_get_messages_errors('picture')) : ?><div class="invalid-feedback"><?php echo _get_messages_errors('picture'); ?></div><?php endif; ?>

                        </div>
                    </div>
                    <!-- <div class="mb-3 input-group has-validation">
                        <label for="picture" class="col-12 col-sm-4 col-form-label">Picture</label>
                        <input type="file" name="picture" class="form-control mx-1" id="picture">

                        <?php if (_get_messages_errors('picture')) : ?><div class="invalid-feedback"><?php echo _get_messages_errors('picture'); ?></div><?php endif; ?>

                    </div> -->

                    <div class="row mb-3 input-group">
                        <div class="col-sm-4 text-end mx-auto"></div>
                        <div class="col-sm-8 text-start mx-auto">
                            <input class="btn btn-success" name="changepp" type="submit" value="Upload">
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</main>

<?php footer_section(); ?>