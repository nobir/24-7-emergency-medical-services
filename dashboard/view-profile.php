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

<?php header_section("EMS | View Profile"); ?>

<main class="container py-2 my-3 border">
    <div class="row">
        <div class="col-12">
            <h1 class="text-center">View Profile</h1>
        </div>
    </div>

    <hr>

    <div class="row d-flex justify-content-center align-items-center">
        <div class="row">

            <?php if (_get_is_logged_in()) side_menu(); ?>

            <div class="col-md-<?php echo _get_is_logged_in() ? "9" : "12"; ?>">
                <ul class="list-group list-group-flush">

                    <li class="list-group-item d-block">
                        <div class="row">
                            <div class="col-md-8"></div>
                            <div class="col-md-4 w-100">
                                <img src="<?php echo !empty(_get_session_val('pp_path')) ? _get_assets_uri(_get_session_val('pp_path'), "uploads") : _get_assets_uri("default-pp.png", "img"); ?>" class="img-thumbnail rounded mx-auto d-block" alt="<?php echo _get_session_val('name'); ?>">
                            </div>
                        </div>
                    </li>

                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-md-3">
                                <spna class="text-dark">Name</spna>
                            </div>
                            <div class="col-md-9">
                                <span class="text-dark"><?php echo _get_session_val('name'); ?></span>
                            </div>
                        </div>
                    </li>

                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-md-3">
                                <spna class="text-dark">Email</spna>
                            </div>
                            <div class="col-md-9">
                                <span class="text-dark"><?php echo _get_session_val('email'); ?></span>
                            </div>
                        </div>
                    </li>

                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-md-3">
                                <spna class="text-dark">Gender</spna>
                            </div>
                            <div class="col-md-9">
                                <span class="text-dark"><?php echo ucfirst(_get_session_val('gender')); ?></span>
                            </div>
                        </div>
                    </li>

                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-md-3">
                                <spna class="text-dark">Death of Birth</spna>
                            </div>
                            <div class="col-md-9">
                                <span class="text-dark"><?php echo date("d/m/Y", strtotime(_get_session_val('dob'))); ?></span>
                            </div>
                        </div>
                    </li>

                    <?php if (_get_session_val('degree') && !empty(_get_session_val('degree'))) : ?>

                        <li class="list-group-item">
                            <div class="row">
                                <div class="col-md-3">
                                    <spna class="text-dark">Degree</spna>
                                </div>
                                <div class="col-md-9">
                                    <span class="text-dark"><?php echo _get_session_val('degree'); ?></span>
                                </div>
                            </div>
                        </li>

                    <?php endif; ?>

                    <?php if (_get_session_val('specialization') && !empty(_get_session_val('specialization'))) : ?>

                        <li class="list-group-item">
                            <div class="row">
                                <div class="col-md-3">
                                    <spna class="text-dark">Specialization</spna>
                                </div>
                                <div class="col-md-9">
                                    <span class="text-dark"><?php echo _get_session_val('specialization'); ?></span>
                                </div>
                            </div>
                        </li>

                    <?php endif; ?>

                    <?php if (_get_session_val('schedule') && !empty(_get_session_val('schedule'))) : ?>

                        <li class="list-group-item">
                            <div class="row">
                                <div class="col-md-3">
                                    <spna class="text-dark">Schedule</spna>
                                </div>
                                <div class="col-md-9">
                                    <span class="text-dark"><?php echo _get_session_val('schedule'); ?></span>
                                </div>
                            </div>
                        </li>

                    <?php endif; ?>

                    <?php if (_get_session_val('work_subdistrict') && !empty(_get_session_val('work_subdistrict'))) : ?>

                        <li class="list-group-item">
                            <div class="row">
                                <div class="col-md-3">
                                    <spna class="text-dark">Work Sub District</spna>
                                </div>
                                <div class="col-md-9">
                                    <span class="text-dark"><?php echo _get_session_val('work_subdistrict'); ?></span>
                                </div>
                            </div>
                        </li>

                    <?php endif; ?>

                </ul>
            </div>

        </div>
    </div>
</main>

<?php footer_section(); ?>