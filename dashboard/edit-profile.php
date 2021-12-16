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

<?php header_section("EMS | Edit Profile"); ?>

<main class="container py-2 my-3 border">
    <div class="row">
        <div class="col-12">
            <h1 class="text-center">Edit Profile</h1>
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

                <form id="edit-profile-form" action="<?php echo _get_url("controllers/EditProfileController.php"); ?>" method="post" class="needs-validation">
                    <div class="row mb-3 has-validation">
                        <label for="name" class="col-sm-3 col-form-label">Name</label>
                        <div class="col-sm-9">
                            <input id="name" type="text" name="name" class="form-control<?php echo _get_messages_css_class_name('name'); ?>" value="<?php echo _get_session_val('name'); ?>" placeholder="Sasuke Uchiha">

                            <?php if (_get_messages_errors('name')) : ?><div class="invalid-feedback"><?php echo _get_messages_errors('name'); ?></div><?php endif; ?>
                        </div>
                    </div>
                    <div class="row mb-3 has-validation">
                        <label for="email" class="col-sm-3 col-form-label">Email</label>
                        <div class="col-sm-9">
                            <input id="email" type="text" name="email" class="form-control<?php echo _get_messages_css_class_name('email'); ?>" value="<?php echo _get_session_val('email'); ?>" placeholder="sasuke@uchiha.com">

                            <?php if (_get_messages_errors('email')) : ?><div class="invalid-feedback"><?php echo _get_messages_errors('email'); ?></div><?php endif; ?>
                        </div>
                    </div>
                    <div class="row mb-3 has-validation">
                        <label for="phone" class="col-sm-3 col-form-label">Phone</label>
                        <div class="col-sm-9">
                            <input id="phone" type="text" name="phone" class="form-control<?php echo _get_messages_css_class_name('phone'); ?>" value="<?php echo _get_session_val('phone'); ?>" placeholder="+88016xxxxxxxx">

                            <?php if (_get_messages_errors('phone')) : ?><div class="invalid-feedback"><?php echo _get_messages_errors('phone'); ?></div><?php endif; ?>
                        </div>
                    </div>
                    <div class="row mb-3 has-validation">
                        <label for="dob" class="col-sm-3 col-form-label">Date of Birth</label>
                        <div class="col-sm-9">
                            <input id="dob" type="date" name="dob" class="form-control<?php echo _get_messages_css_class_name('dob'); ?>" value="<?php echo _get_session_val('dob'); ?>">

                            <?php if (_get_messages_errors('dob')) : ?><div class="invalid-feedback"><?php echo _get_messages_errors('dob'); ?></div><?php endif; ?>
                        </div>
                    </div>
                    <fieldset class="row mb-3">
                        <legend class="col-form-label col-sm-3 pt-0">Gender</legend>
                        <div class="col-sm-9">
                            <div class="form-check">
                                <input id="male" type="radio" name="gender" class="form-check-input<?php echo _get_session_val('gender') === "male" ? " is-valid" : ""; ?>" value="male" <?php echo _get_session_val('gender') === "male" ? " checked" : ""; ?>>
                                <label for="male" class="form-check-label">Male</label>
                            </div>
                            <div class="form-check">
                                <input id="female" type="radio" name="gender" class="form-check-input<?php echo _get_session_val('gender') === "female" ? " is-valid" : ""; ?>" value="female" <?php echo _get_session_val('gender') === "female" ? " checked" : ""; ?>>
                                <label for="female" class="form-check-label">Female</label>
                            </div>
                            <div class="form-check">
                                <input id="other" type="radio" name="gender" class="form-check-input<?php echo _get_session_val('gender') === "other" ? " is-valid" : ""; ?>" value="other" <?php echo _get_session_val('gender') === "other" ? " checked" : ""; ?>>
                                <label for="other" class="form-check-label">Other</label>
                            </div>

                            <input class="<?php echo trim(_get_messages_css_class_name('gender')); ?>" type="hidden">

                            <?php if (_get_messages_errors('gender')) : ?><div class="invalid-feedback"><?php echo _get_messages_errors('gender'); ?></div><?php endif; ?>

                        </div>
                    </fieldset>


                    <!-- Doctor Extra inputs -->

                    <?php if (_get_session_val('utype') === 'doctor') : ?>

                        <div class="row mb-3 has-validation">
                            <label for="degree" class="col-sm-3 col-form-label">Degree</label>
                            <div class="col-sm-9">
                                <input id="degree" type="text" name="degree" class="form-control<?php echo _get_messages_css_class_name('degree'); ?>" value="<?php echo _get_session_val('degree'); ?>" placeholder="e.g MBBS, FCPS (Medicine), PHD (USA)">

                                <?php if (_get_messages_errors('degree')) : ?><div class="invalid-feedback"><?php echo _get_messages_errors('degree'); ?></div><?php endif; ?>
                            </div>
                        </div>

                    <?php endif; ?>

                    <?php if (_get_session_val('utype') === 'doctor') : ?>

                        <div class="row mb-3 has-validation">
                            <label for="specialization" class="col-sm-3 col-form-label">Specialization</label>
                            <div class="col-sm-9">
                                <input id="specialization" type="text" name="specialization" class="form-control<?php echo _get_messages_css_class_name('specialization'); ?>" value="<?php echo _get_session_val('specialization'); ?>" placeholder="e.g Cardiology">

                                <?php if (_get_messages_errors('specialization')) : ?><div class="invalid-feedback"><?php echo _get_messages_errors('specialization'); ?></div><?php endif; ?>
                            </div>
                        </div>

                    <?php endif; ?>

                    <?php if (_get_session_val('utype') === 'doctor') : ?>

                        <div class="row mb-3 has-validation">
                            <label for="schedule" class="col-sm-3 col-form-label">Schedule</label>
                            <div class="col-sm-9">
                                <input id="schedule" type="text" name="schedule" class="form-control<?php echo _get_messages_css_class_name('schedule'); ?>" value="<?php echo _get_session_val('schedule'); ?>" placeholder="e.g Sun - Thu - 11:00 AM - 05:00 PM">

                                <?php if (_get_messages_errors('schedule')) : ?><div class="invalid-feedback"><?php echo _get_messages_errors('schedule'); ?></div><?php endif; ?>
                            </div>
                        </div>

                    <?php endif; ?>

                    <!-- Doctor END -->

                    <!-- Emanager Extra inputs -->

                    <?php if (_get_session_val('utype') === 'emanager') : ?>

                        <div class="row mb-3 has-validation">
                            <label for="work_subdistrict" class="col-sm-3 col-form-label">Work Sub District</label>
                            <div class="col-sm-9">
                                <input id="work_subdistrict" type="text" name="work_subdistrict" class="form-control<?php echo _get_messages_css_class_name('work_subdistrict'); ?>" value="<?php echo _get_session_val('work_subdistrict'); ?>" placeholder="e.g Mirpur">

                                <?php if (_get_messages_errors('work_subdistrict')) : ?><div class="invalid-feedback"><?php echo _get_messages_errors('work_subdistrict'); ?></div><?php endif; ?>
                            </div>
                        </div>

                    <?php endif; ?>

                    <?php if(_get_session_val('utype') === 'emanager' || _get_session_val('utype') === 'doctor' || _get_session_val('utype') === 'patient') : ?>

                    <div class="row mb-3 has-validation">
                        <label for="area" class="col-sm-3 col-form-label">Area</label>
                        <div class="col-sm-9">
                            <input id="area" type="text" name="area" class="form-control<?php echo _get_messages_css_class_name('area'); ?>" value="<?php echo _get_session_val('area'); ?>" placeholder="e.g Moddho Pikepara">

                            <?php if (_get_messages_errors('area')) : ?><div class="invalid-feedback"><?php echo _get_messages_errors('area'); ?></div><?php endif; ?>
                        </div>
                    </div>
                    <div class="row mb-3 has-validation">
                        <label for="subdistrict" class="col-sm-3 col-form-label">Sub District</label>
                        <div class="col-sm-9">
                            <input id="subdistrict" type="text" name="subdistrict" class="form-control<?php echo _get_messages_css_class_name('subdistrict'); ?>" value="<?php echo _get_session_val('subdistrict'); ?>" placeholder="e.g Mirpur">

                            <?php if (_get_messages_errors('subdistrict')) : ?><div class="invalid-feedback"><?php echo _get_messages_errors('subdistrict'); ?></div><?php endif; ?>
                        </div>
                    </div>
                    <div class="row mb-3 has-validation">
                        <label for="district" class="col-sm-3 col-form-label">District</label>
                        <div class="col-sm-9">
                            <input id="district" type="text" name="district" class="form-control<?php echo _get_messages_css_class_name('district'); ?>" value="<?php echo _get_session_val('district'); ?>" placeholder="e.g Dhaka">

                            <?php if (_get_messages_errors('district')) : ?><div class="invalid-feedback"><?php echo _get_messages_errors('district'); ?></div><?php endif; ?>
                        </div>
                    </div>
                    <div class="row mb-3 has-validation">
                        <label for="division" class="col-sm-3 col-form-label">Division</label>
                        <div class="col-sm-9">
                            <input id="division" type="text" name="division" class="form-control<?php echo _get_messages_css_class_name('division'); ?>" value="<?php echo _get_session_val('division'); ?>" placeholder="e.g Dhaka">

                            <?php if (_get_messages_errors('division')) : ?><div class="invalid-feedback"><?php echo _get_messages_errors('division'); ?></div><?php endif; ?>
                        </div>
                    </div>

                    <?php endif; ?>

                    <div class="row mb-3 has-validation">
                        <div class="col-sm-3 mb-3 text-sm-end"></div>
                        <div class="col-sm-3 mb-3 text-sm-start">
                            <button id="edit-profile-btn" type="submit" name="edit-profile" class="btn btn-success">Save</button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</main>

<?php footer_section(); ?>