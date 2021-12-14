<?php

/**
 * Can access direcly by URL
 */

define("_DIRECT_ACCESS", true);

require_once dirname(__FILE__) . "/helper/functions.php";

// _print_r(_get_messages_data('password'));
// _var_dump(password_verify("asd@#123", _get_messages_data('password')));

header_section("EMS | Registration Page");
?>

<main class="container py-2 my-3 border">
    <div class="row">
        <div class="col-12">
            <h1 class="text-center">Registration Page</h1>
        </div>
    </div>

    <hr>

    <div class="row d-flex justify-content-center align-items-center">
        <div class="col-12 col-md-8 col-lg-7">

            <?php _success_unsuccess_messages(); ?>

        </div>

        <div class="col-12 col-md-8 col-lg-7">
            <form id="registration-form" action="<?php echo _get_url("controllers/RegistrationController.php"); ?>" method="post" class="needs-validation" onchange="validate_registration(this);">
                <div class="row mb-3 has-validation">
                    <label for="name" class="col-sm-3 col-form-label">Name</label>
                    <div class="col-sm-9">
                        <input id="name" type="text" name="name" class="form-control<?php echo _get_messages_css_class_name('name'); ?>" value="<?php echo _get_messages_data('name'); ?>" placeholder="Sasuke Uchiha" onkeyup="validate_name(this);">

                        <div class="invalid-feedback"><?php echo _get_messages_errors('name'); ?></div>
                    </div>
                </div>
                <div class="row mb-3 has-validation">
                    <label for="email" class="col-sm-3 col-form-label">Email</label>
                    <div class="col-sm-9">
                        <input id="email" type="text" name="email" class="form-control<?php echo _get_messages_css_class_name('email'); ?>" value="<?php echo _get_messages_data('email'); ?>" placeholder="sasuke@uchiha.com" onkeyup="validate_email(this);">

                        <div class="invalid-feedback"><?php echo _get_messages_errors('email'); ?></div>
                    </div>
                </div>
                <div class="row mb-3 has-validation">
                    <label for="phone" class="col-sm-3 col-form-label">Phone</label>
                    <div class="col-sm-9">
                        <input id="phone" type="text" name="phone" class="form-control<?php echo _get_messages_css_class_name('phone'); ?>" value="<?php echo _get_messages_data('phone'); ?>" placeholder="+88016xxxxxxxx" onkeyup="validate_phoneNumber(this);">

                        <div class="invalid-feedback"><?php echo _get_messages_errors('phone'); ?></div>
                    </div>
                </div>
                <div class="row mb-3 has-validation">
                    <label for="password" class="col-sm-3 col-form-label">Password</label>
                    <div class="col-sm-9">
                        <input id="password" type="password" name="password" class="form-control<?php echo _get_messages_css_class_name('password'); ?>" value="<?php echo _get_messages_data('password'); ?>" onkeyup="validate_password(this);">

                        <div class="invalid-feedback"><?php echo _get_messages_errors('password'); ?></div>
                    </div>
                </div>
                <div class="row mb-3 has-validation">
                    <label for="cpassword" class="col-sm-3 col-form-label">Confirm Password</label>
                    <div class="col-sm-9">
                        <input id="cpassword" type="password" name="cpassword" class="form-control<?php echo _get_messages_css_class_name('cpassword'); ?>" value="<?php echo _get_messages_data('cpassword'); ?>" onkeyup="validate_cpassword(this);">

                        <div class="invalid-feedback"><?php echo _get_messages_errors('cpassword'); ?></div>
                    </div>
                </div>
                <div class="row mb-3 has-validation">
                    <label for="dob" class="col-sm-3 col-form-label">Date of Birth</label>
                    <div class="col-sm-9">
                        <input id="dob" type="date" name="dob" class="form-control<?php echo _get_messages_css_class_name('dob'); ?>" value="<?php echo _get_messages_data('dob'); ?>" onchange="validate_dob(this);">

                        <div class="invalid-feedback"><?php echo _get_messages_errors('dob'); ?></div>
                    </div>
                </div>
                <fieldset class="row mb-3">
                    <legend class="col-form-label col-sm-3 pt-0">Gender</legend>
                    <div class="col-sm-9">
                        <div class="form-check">
                            <input id="male" type="radio" name="gender" class="form-check-input<?php echo _get_messages_data('gender') === "male" ? " is-valid" : ""; ?>" value="male" <?php echo _get_messages_data('gender') === "male" ? " checked" : ""; ?>>
                            <label for="male" class="form-check-label">Male</label>
                        </div>
                        <div class="form-check">
                            <input id="female" type="radio" name="gender" class="form-check-input<?php echo _get_messages_data('gender') === "female" ? " is-valid" : ""; ?>" value="female" <?php echo _get_messages_data('gender') === "female" ? " checked" : ""; ?>>
                            <label for="female" class="form-check-label">Female</label>
                        </div>
                        <div class="form-check">
                            <input id="other" type="radio" name="gender" class="form-check-input<?php echo _get_messages_data('gender') === "other" ? " is-valid" : ""; ?>" value="other" <?php echo _get_messages_data('gender') === "other" ? " checked" : ""; ?>>
                            <label for="other" class="form-check-label">Other</label>
                        </div>

                        <input class="<?php echo trim(_get_messages_css_class_name('gender')); ?>" type="hidden">

                        <div class="invalid-feedback"><?php echo _get_messages_errors('gender'); ?></div>

                    </div>
                </fieldset>
                <fieldset class="row mb-3">
                    <legend class="col-form-label col-sm-3 pt-0">User Type</legend>
                    <div class="col-sm-9">
                        <div class="form-check">
                            <input id="doctor" type="radio" name="utype" class="form-check-input<?php echo _get_messages_data('utype') === "doctor" ? " is-valid" : ""; ?>" value="doctor" <?php echo _get_messages_data('utype') === "doctor" ? " checked" : ""; ?>>
                            <label for="doctor" class="form-check-label">Doctor</label>
                        </div>
                        <div class="form-check">
                            <input id="patient" type="radio" name="utype" class="form-check-input<?php echo _get_messages_data('utype') === "patient" ? " is-valid" : ""; ?>" value="patient" <?php echo _get_messages_data('utype') === "patient" ? " checked" : ""; ?>>
                            <label for="patient" class="form-check-label">Patient</label>
                        </div>
                        <div class="form-check">
                            <input id="emanager" type="radio" name="utype" class="form-check-input<?php echo _get_messages_data('utype') === "emanager" ? " is-valid" : ""; ?>" value="emanager" <?php echo _get_messages_data('utype') === "emanager" ? " checked" : ""; ?>>
                            <label for="emanager" class="form-check-label">Emergency Manager</label>
                        </div>

                        <input class="<?php echo trim(_get_messages_css_class_name('utype')); ?>" type="hidden">

                        <div class="invalid-feedback"><?php echo _get_messages_errors('utype'); ?></div>

                    </div>
                </fieldset>
                <div class="row mb-3 has-validation">
                    <label for="area" class="col-sm-3 col-form-label">Area</label>
                    <div class="col-sm-9">
                        <input id="area" type="text" name="area" class="form-control<?php echo _get_messages_css_class_name('area'); ?>" value="<?php echo _get_messages_data('area'); ?>" placeholder="e.g Moddho Pikepara" onkeyup="validate_area(this);">

                        <div class="invalid-feedback"><?php echo _get_messages_errors('area'); ?></div>
                    </div>
                </div>
                <div class="row mb-3 has-validation">
                    <label for="subdistrict" class="col-sm-3 col-form-label">Sub District</label>
                    <div class="col-sm-9">
                        <input id="subdistrict" type="text" name="subdistrict" class="form-control<?php echo _get_messages_css_class_name('subdistrict'); ?>" value="<?php echo _get_messages_data('subdistrict'); ?>" placeholder="e.g Mirpur" onkeyup="validate_subdistrict(this);">

                        <div class="invalid-feedback"><?php echo _get_messages_errors('subdistrict'); ?></div>
                    </div>
                </div>
                <div class="row mb-3 has-validation">
                    <label for="district" class="col-sm-3 col-form-label">District</label>
                    <div class="col-sm-9">
                        <input id="district" type="text" name="district" class="form-control<?php echo _get_messages_css_class_name('district'); ?>" value="<?php echo _get_messages_data('district'); ?>" placeholder="e.g Dhaka" onkeyup="validate_district(this);">

                        <div class="invalid-feedback"><?php echo _get_messages_errors('district'); ?></div>
                    </div>
                </div>
                <div class="row mb-3 has-validation">
                    <label for="division" class="col-sm-3 col-form-label">Division</label>
                    <div class="col-sm-9">
                        <input id="division" type="text" name="division" class="form-control<?php echo _get_messages_css_class_name('division'); ?>" value="<?php echo _get_messages_data('division'); ?>" placeholder="e.g Dhaka" onkeyup="validate_division(this);">

                        <div class="invalid-feedback"><?php echo _get_messages_errors('division'); ?></div>
                    </div>
                </div>
                <div class="row mb-3 has-validation">
                    <div class="col-sm-9 offset-sm-3">
                        <div class="form-check">
                            <input id="privacy" type="checkbox" name="privacy" class="form-check-input<?php echo _get_messages_css_class_name('privacy'); ?>" <?php echo _get_messages_data('privacy') === "on" ? " checked" : ""; ?> onchange="validate_privacy(this);">
                            <label for="privacy" class="form-check-label"><a href="" target="_blank" class="link-primary">Terms and Conditions</a></label>

                            <div class="invalid-feedback"><?php echo _get_messages_errors('privacy'); ?></div>
                        </div>
                    </div>
                </div>
                <div class="row mb-3 has-validation">
                    <div class="col-sm-3 mb-3 text-sm-end">
                        <button id="reset-btn" type="reset" class="btn btn-success">Reset</button>
                    </div>
                    <div class="col-sm-3 mb-3 text-sm-start">
                        <button id="registration-btn" type="submit" name="registration" class="btn btn-success">Registration</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</main>

<?php footer_section(); ?>