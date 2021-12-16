"use strict";

document.addEventListener("DOMContentLoaded", () => {
    initialize();

    const form = getElemById("deleteuserform");
    const dark_mode_1_button = getElemById("dark_mode_1");
    const dark_mode_2_button = getElemById("dark_mode_2");

    toggleDarkMode(dark_mode_1_button);
    toggleDarkMode(dark_mode_2_button);
});

const validate_ambulance_phone = (phone) => {
    // return;
    const err_phone = phone.parentNode.querySelector(".invalid-feedback");
    // console.log(err_phone);

    let request = $.post(
        window.location.origin +
            "/Project/controllers/AmbulancePhoneDuplicationAJAXController.php",
        {
            phone: phone.value,
            ambulancephoneajax: "true",
        }
    );

    request.done((response) => {
        let messages = JSON.parse(response);

        // console.log(messages);
        // return;

        if (messages.data.phone) {
            phone.classList.remove("is-invalid");
            phone.classList.add("is-valid");
            err_phone.innerText = "";
        } else if (messages.errors) {
            phone.classList.remove("is-valid");
            phone.classList.add("is-invalid");
            err_phone.innerText = messages.errors.phone;
        }
    });
};

const validate_hospital_email = (email) => {
    // return;
    const err_email = email.parentNode.querySelector(".invalid-feedback");
    // console.log(err_email);

    let request = $.post(
        window.location.origin +
            "/Project/controllers/HospitalEmailDuplicationAJAXController.php",
        {
            email: email.value,
            hospitalemailajax: "true",
        }
    );

    request.done((response) => {
        let messages = JSON.parse(response);

        // console.log(messages);
        // return;

        if (messages.data.email) {
            email.classList.remove("is-invalid");
            email.classList.add("is-valid");
            err_email.innerText = "";
        } else if (messages.errors) {
            email.classList.remove("is-valid");
            email.classList.add("is-invalid");
            err_email.innerText = messages.errors.email;
        }
    });
};

const validate_currentpass = (currentpass) => {
    // console.log(currentpass);

    const err_currentpass =
        currentpass.parentNode.querySelector(".invalid-feedback");
    // console.log(err_currentpass);

    let request = $.post(
        window.location.origin +
            "/Project/controllers/ChangePasswordAJAXController.php",
        {
            currentpass: currentpass.value,
            changepasswordajax: "true",
        }
    );

    request.done((response) => {
        // console.log(JSON.parse(response));
        let messages = JSON.parse(response);

        if (messages.data.currentpass) {
            currentpass.classList.remove("is-invalid");
            currentpass.classList.add("is-valid");
            err_currentpass.innerText = "";
        } else if (messages.errors) {
            currentpass.classList.remove("is-valid");
            currentpass.classList.add("is-invalid");
            err_currentpass.innerText = messages.errors.currentpass;
        }
    });
};
const validate_newpass = (newpass) => {
    // console.log(newpass);

    const err_newpass = newpass.parentNode.querySelector(".invalid-feedback");
    // console.log(err_newpass);

    let request = $.post(
        window.location.origin +
            "/Project/controllers/ChangePasswordAJAXController.php",
        {
            newpass: newpass.value,
            changepasswordajax: "true",
        }
    );

    request.done((response) => {
        // console.log(JSON.parse(response));
        let messages = JSON.parse(response);

        if (messages.data.newpass) {
            newpass.classList.remove("is-invalid");
            newpass.classList.add("is-valid");
            err_newpass.innerText = "";
        } else if (messages.errors) {
            newpass.classList.remove("is-valid");
            newpass.classList.add("is-invalid");
            err_newpass.innerText = messages.errors.newpass;
        }
    });
};

const validate_retypepass = (retypepass) => {
    // console.log(retypepass);

    const err_retypepass =
        retypepass.parentNode.querySelector(".invalid-feedback");
    const newpass = retypepass.parentNode.parentNode.parentNode.querySelector(
        "input[name=newpass]"
    );
    // console.log(err_retypepass);
    // console.log(newpass);

    let request = $.post(
        window.location.origin +
            "/Project/controllers/ChangePasswordAJAXController.php",
        {
            newpass: newpass.value,
            retypepass: retypepass.value,
            changepasswordajax: "true",
        }
    );

    request.done((response) => {
        // console.log(JSON.parse(response));
        let messages = JSON.parse(response);

        if (messages.data.retypepass) {
            retypepass.classList.remove("is-invalid");
            retypepass.classList.add("is-valid");
            err_retypepass.innerText = "";
        } else if (messages.errors) {
            retypepass.classList.remove("is-valid");
            retypepass.classList.add("is-invalid");
            err_retypepass.innerText = messages.errors.retypepass;
        }
    });
};

const setCookie = (cname, cvalue, exdays) => {
    const d = new Date();
    d.setTime(d.getTime() + exdays * 24 * 60 * 60 * 1000);
    let expires = "expires=" + d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
};

const getCookie = (cname) => {
    let name = cname + "=";
    let ca = document.cookie.split(";");

    for (let i = 0; i < ca.length; i++) {
        let c = ca[i];
        while (c.charAt(0) == " ") {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
};

const getElemById = (id_selector) => {
    return document.getElementById(id_selector);
};

const getElem = (selector) => {
    return document.querySelector(selector);
};

const getElemAll = (selector) => {
    return document.querySelectorAll(selector);
};

const toggleDarkMode = (dark_mode_button) => {
    if (dark_mode_button) {
        dark_mode_button.addEventListener("click", (e) => {
            e.preventDefault();

            if (getCookie("darkmode") === "true") {
                DarkReader.disable();
                setCookie("darkmode", "false", 365);
            } else {
                DarkReader.enable();
                setCookie("darkmode", "true", 365);
            }
        });
    }
};

const confirmDelete = (event, delete_button) => {
    event.preventDefault();

    if (delete_button) {
        if (confirm("Are you sure you want to delete?")) {
            window.location.href = delete_button.getAttribute("href");
        } else {
            return false;
        }
    }
};

const confirmReject = (event, reject_button) => {
    event.preventDefault();

    if (reject_button) {
        if (confirm("Are you sure you want to reject?")) {
            window.location.href = reject_button.getAttribute("href");
        } else {
            return false;
        }
    }
};

const searchAppointment = (event, form) => {
    // console.log(event, form);

    // event.preventDefault();
    // console.log(form['name'].value);
    // console.log(form['email'].value);

    let name = form["name"];
    let email = form["email"];

    let err_email = email.parentNode.querySelector(".invalid-feedback");

    let request = $.post(
        window.location.origin +
            "/Project/controllers/SearchAppointmentAJAXController.php",
        {
            name: name.value.trim(),
            email: email.value.trim(),
            searchappointmentajax: "true",
        }
    );

    request.done((response) => {
        // console.log(JSON.parse(response).data.appointments);
        let messages = JSON.parse(response);
        let has_err = false;

        // console.log(email.parentNode.querySelector(".invalid-feedback"));

        if (messages.data.email) {
            email.classList.remove("is-invalid");
            email.classList.add("is-valid");
            err_email.innerText = "";
        } else if (messages.errors.email) {
            email.classList.remove("is-valid");
            email.classList.add("is-invalid");
            err_email.innerText = messages.errors.email;
            has_err = true;
        }

        if (!has_err) {
            let html = ``;

            if (messages.data.appointments) {
                messages.data.appointments.forEach((appointment) => {
                    html += `
                    <tr>
                        <td>${appointment.p_name}</td>
                        <td>${appointment.p_email}</td>
                        <td>${appointment.p_phone}</td>
                        <td>${appointment.ap_reason}</td>
                        <td class="text-center">
                            <a href="../../controllers/RejectAppointmentController.php?id=${appointment.ap_id}" class="btn btn-danger mb-3" onclick="confirmReject(event, this);">Reject</a>
                            <a href="../../controllers/AcceptAppointmentController.php?id=${appointment.ap_id}" class="btn btn-success mb-3">Accept</a>
                        </td>
                    </tr>
                `;
                });
            } else {
                html = `
                    <tr class="text-center">
                        <td colspan="6">No Appointments Found</td>
                    </tr>
                `;
            }

            $("#appointments-data").html(html);
        }
    });
};

/**
 *
 * Validation Controller
 *
 */

const validate_name = (name) => {
    const err_name = name.parentNode.querySelector(".invalid-feedback");

    if (name.value.length === 0) {
        name.classList.remove("is-valid");
        name.classList.add("is-invalid");
        err_name.innerText = "Name is required";
    } else if (name.value.length < 2) {
        name.classList.remove("is-valid");
        name.classList.add("is-invalid");
        err_name.innerText = "Name must be greater than 2 character";
    } else if (!name.value.match(/^[a-zA-Z-.]/g)) {
        name.classList.remove("is-valid");
        name.classList.add("is-invalid");
        err_name.innerText =
            "Name must be contains alpha character, (.) and (-)";
    } else {
        name.classList.remove("is-invalid");
        name.classList.add("is-valid");
        err_name.innerText = "";
        return true;
    }

    return false;
};

const validate_email = (email) => {
    const err_email = email.parentNode.querySelector(".invalid-feedback");

    if (email.value.length === 0) {
        email.classList.remove("is-valid");
        email.classList.add("is-invalid");
        err_email.innerText = "Email is required";
    } else if (
        !email.value.match(
            /^[a-zA-Z0-9._-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)+(?:\.[a-zA-Z0-9-]+)*$/g
        )
    ) {
        email.classList.remove("is-valid");
        email.classList.add("is-invalid");
        err_email.innerText = "Email is not valid";
    } else {
        email.classList.remove("is-invalid");
        email.classList.add("is-valid");
        err_email.innerText = "";
        return true;
    }

    return false;
};

/**
 * Regular Expression
 *
 * @see https://regexr.com/69opj
 */

const validate_phoneNumber = (phoneNumber) => {
    const err_phoneNumber =
        phoneNumber.parentNode.querySelector(".invalid-feedback");

    if (phoneNumber.value.length === 0) {
        phoneNumber.classList.remove("is-valid");
        phoneNumber.classList.add("is-invalid");
        err_phoneNumber.innerText = "Phone Number is required";
    } else if (
        !phoneNumber.value.match(/^(((\+8801)|(01))[3-9]\d{1}[0-9]\d{6})$/g)
    ) {
        phoneNumber.classList.remove("is-valid");
        phoneNumber.classList.add("is-invalid");
        err_phoneNumber.innerText = "Invalid Phone Number";
    } else {
        phoneNumber.classList.remove("is-invalid");
        phoneNumber.classList.add("is-valid");
        err_phoneNumber.innerText = "";
        return true;
    }

    return false;
};

const validate_password = (password) => {
    const err_password = password.parentNode.querySelector(".invalid-feedback");

    if (password.value.length === 0) {
        password.classList.remove("is-valid");
        password.classList.add("is-invalid");
        err_password.innerText = "Password is required";
    } else if (password.value.length < 8) {
        password.classList.remove("is-valid");
        password.classList.add("is-invalid");
        err_password.innerText = "Password must be 8 characters or greater";
    } else if (!password.value.match(/[@#$%]+/g)) {
        err_password.innerText =
            "Password must include special characters (@ # $ %)";
    } else {
        password.classList.remove("is-invalid");
        password.classList.add("is-valid");
        err_password.innerText = "";
        return true;
    }

    return false;
};

const validate_cpassword = (cpassword) => {
    const err_cpassword =
        cpassword.parentNode.querySelector(".invalid-feedback");
    const password = cpassword.parentNode.parentNode.parentNode.querySelector(
        "input[name=password]"
    ).value;

    console.log(password);

    if (cpassword.value.length === 0) {
        cpassword.classList.remove("is-valid");
        cpassword.classList.add("is-invalid");
        err_cpassword.innerText = "Confirm Password is required";
    } else if (cpassword.value !== password) {
        cpassword.classList.remove("is-valid");
        cpassword.classList.add("is-invalid");
        err_cpassword.innerText = "Confirm Password must equal to Password";
    } else {
        cpassword.classList.remove("is-invalid");
        cpassword.classList.add("is-valid");
        err_cpassword.innerText = "";
        return true;
    }

    return false;
};

const validate_registration = (form) => {
    // validate_gender(form['gender']);
    // console.log(form['gender']);
};

// const validate_gender = (genders) => {

//     console.dir(genders);
//     let err_gender = null
//     for (let i = 0; i < genders.length; ++i) {
//         err_gender = genders[i].parentNode.parentNode.querySelector(".invalid-feedback");
//         if (genders[i].checked) {
//             let err_msg_gender = genders[i].parentNode.parentNode.querySelector("input[type=hidden]");
//             // console.log(err_msg_gender);
//             err_msg_gender.classList.remove("is-invalid");
//             err_msg_gender.classList.add("is-valid");
//             err_gender.innerText = "";

//             if (!genders[i].value.trim().match(/(male|female|other)/g)) {
//                 genders[i].classList.remove("is-valid");
//                 genders[i].classList.add("is-invalid");
//                 err_gender.innerText = "Gender is not valid";
//             } else {
//                 genders[i].classList.remove("is-invalid");
//                 genders[i].classList.add("is-valid");
//                 err_gender.innerText = "";
//                 break;
//             }
//         } else {
//             genders[i].classList.remove("is-valid");
//             genders[i].classList.add("is-invalid");
//             err_gender.innerText = "Gender is required";
//         }
//     }

//     return err_gender.innerText.length === 0;
// };

const validate_dob = (dob) => {
    const err_dob = dob.parentNode.querySelector(".invalid-feedback");

    if (dob.value.length === 0) {
        dob.classList.remove("is-valid");
        dob.classList.add("is-invalid");
        err_dob.innerText = "Date of birth is required";
    } else if (!dob.value.match(/^\d{4}-\d{2}-\d{2}$/g)) {
        dob.classList.remove("is-valid");
        dob.classList.add("is-invalid");
        err_dob.innerText = "Date of birth is not valid";
    } else {
        dob.classList.remove("is-invalid");
        dob.classList.add("is-valid");
        err_dob.innerText = "";
        return true;
    }

    return false;
};

const validate_degree = (degree) => {
    const err_degree = degree.parentNode.querySelector(".invalid-feedback");

    if (degree.value.length === 0) {
        degree.classList.remove("is-valid");
        degree.classList.add("is-invalid");
        err_degree.innerText = "Degree is required";
    } else if (!degree.value.match(/^[\w_\-\.\s,\:]*$/g)) {
        degree.classList.remove("is-valid");
        degree.classList.add("is-invalid");
        err_degree.innerText =
            "Degree must be alphanumaric and can be include (space, : , - _ #)";
    } else {
        degree.classList.remove("is-invalid");
        degree.classList.add("is-valid");
        err_degree.innerText = "";
        return true;
    }

    return false;
};

const validate_specialization = (specialization) => {
    const err_specialization =
        specialization.parentNode.querySelector(".invalid-feedback");

    if (specialization.value.length === 0) {
        specialization.classList.remove("is-valid");
        specialization.classList.add("is-invalid");
        err_specialization.innerText = "Specialization is required";
    } else if (!specialization.value.match(/^[\w_\-\.\s,\:]*$/g)) {
        specialization.classList.remove("is-valid");
        specialization.classList.add("is-invalid");
        err_specialization.innerText =
            "Specialization must be alphanumaric and can be include (space, : , - _ #)";
    } else {
        specialization.classList.remove("is-invalid");
        specialization.classList.add("is-valid");
        err_specialization.innerText = "";
        return true;
    }

    return false;
};

const validate_schedule = (schedule) => {
    const err_schedule = schedule.parentNode.querySelector(".invalid-feedback");

    if (schedule.value.length === 0) {
        schedule.classList.remove("is-valid");
        schedule.classList.add("is-invalid");
        err_schedule.innerText = "Schedule is required";
    } else if (!schedule.value.match(/^[\w_\-\.\s,\:]*$/g)) {
        schedule.classList.remove("is-valid");
        schedule.classList.add("is-invalid");
        err_schedule.innerText =
            "Schedule must be alphanumaric and can be include (space, : , - _ #)";
    } else {
        schedule.classList.remove("is-invalid");
        schedule.classList.add("is-valid");
        err_schedule.innerText = "";
        return true;
    }

    return false;
};

const validate_work_subdistrict = (work_subdistrict) => {
    const err_work_subdistrict =
        work_subdistrict.parentNode.querySelector(".invalid-feedback");

    if (work_subdistrict.value.length === 0) {
        work_subdistrict.classList.remove("is-valid");
        work_subdistrict.classList.add("is-invalid");
        err_work_subdistrict.innerText = "Work Subdistrict is required";
    } else if (!work_subdistrict.value.match(/^[\w\s\-\.]*$/g)) {
        work_subdistrict.classList.remove("is-valid");
        work_subdistrict.classList.add("is-invalid");
        err_work_subdistrict.innerText =
            "Work Subdistrict must be alphanumaric and can be include (space, : , - _ #)";
    } else {
        work_subdistrict.classList.remove("is-invalid");
        work_subdistrict.classList.add("is-valid");
        err_work_subdistrict.innerText = "";
        return true;
    }

    return false;
};

const validate_area = (area) => {
    const err_area = area.parentNode.querySelector(".invalid-feedback");

    // if (area.value.length === 0) {
    //     area.classList.remove("is-valid");
    //     area.classList.add("is-invalid");
    //     err_area.innerText = "area is required";
    // } else

    if (!area.value.match(/^[\w_\-\.\s,\:#]*$/g)) {
        area.classList.remove("is-valid");
        area.classList.add("is-invalid");
        err_area.innerText =
            "Area must be alphanumaric and can be include (space, : , - _ #)";
    } else {
        area.classList.remove("is-invalid");
        if (area.value.length !== 0) {
            area.classList.add("is-valid");
        }
        err_area.innerText = "";
        return true;
    }

    return false;
};

const validate_subdistrict = (subdistrict) => {
    const err_subdistrict =
        subdistrict.parentNode.querySelector(".invalid-feedback");

    // if (subdistrict.value.length === 0) {
    //     subdistrict.classList.remove("is-valid");
    //     subdistrict.classList.add("is-invalid");
    //     err_subdistrict.innerText = "Subdistrict is required";
    // } else
    if (!subdistrict.value.match(/^[\w\s\-\.]*$/g)) {
        subdistrict.classList.remove("is-valid");
        subdistrict.classList.add("is-invalid");
        err_subdistrict.innerText =
            "Subdistrict must be alphanumaric and can be include (space, -, .)";
    } else {
        subdistrict.classList.remove("is-invalid");
        if (subdistrict.value.length !== 0) {
            subdistrict.classList.add("is-valid");
        }
        err_subdistrict.innerText = "";
        return true;
    }

    return false;
};

const validate_district = (district) => {
    const err_district = district.parentNode.querySelector(".invalid-feedback");

    // if (district.value.length === 0) {
    //     district.classList.remove("is-valid");
    //     district.classList.add("is-invalid");
    //     err_district.innerText = "District is required";
    // } else

    if (!district.value.match(/^[\w_\-\.\s,\:]*$/g)) {
        district.classList.remove("is-valid");
        district.classList.add("is-invalid");
        err_district.innerText =
            "District must be alphanumaric and can be include (space, -, .)";
    } else {
        district.classList.remove("is-invalid");
        if (district.value.length !== 0) {
            district.classList.add("is-valid");
        }
        err_district.innerText = "";
        return true;
    }

    return false;
};

const validate_division = (division) => {
    const err_division = division.parentNode.querySelector(".invalid-feedback");

    // if (division.value.length === 0) {
    //     division.classList.remove("is-valid");
    //     division.classList.add("is-invalid");
    //     err_division.innerText = "division is required";
    // } else

    if (!division.value.match(/^[\w_\-\.\s,\:]*$/g)) {
        division.classList.remove("is-valid");
        division.classList.add("is-invalid");
        err_division.innerText =
            "Division must be alphanumaric and can be include (space, -, .)";
    } else {
        division.classList.remove("is-invalid");
        if (division.value.length !== 0) {
            division.classList.add("is-valid");
        }
        err_division.innerText = "";
        return true;
    }

    return false;
};

const validate_privacy = (privacy) => {
    const err_privacy = privacy.parentNode.querySelector(".invalid-feedback");

    // console.dir(privacy);

    if (!privacy.checked) {
        privacy.classList.remove("is-valid");
        privacy.classList.add("is-invalid");
        err_privacy.innerText = "Terms and Condition is required";
    } else if (!privacy.value.match(/(on|off)/g)) {
        privacy.classList.remove("is-valid");
        privacy.classList.add("is-invalid");
        err_privacy.innerText = "Terms and Condition is invalid";
    } else {
        privacy.classList.remove("is-invalid");
        privacy.classList.add("is-valid");
        err_privacy.innerText = "";
        return true;
    }

    return false;
};

/**
 *
 * Registration Validation Controller
 *
 */

const validate_utype_registration = (utype_registration) => {
    const err_utype_registration =
        utype_registration.parentNode.querySelector(".invalid-feedback");

    if (utype_registration.length === 0) {
        utype_registration.classList.remove("is-valid");
        utype_registration.classList.add("is-invalid");
        err_utype_registration.innerText = "User Type is required";
    } else if (!utype_registration.match(/(doctor|patient|emanager)/g)) {
        utype_registration.classList.remove("is-valid");
        utype_registration.classList.add("is-invalid");
        err_utype_registration.innerText = "User Type is invalid";
    } else {
        utype_registration.classList.remove("is-invalid");
        utype_registration.classList.add("is-valid");
        err_utype_registration.innerText = "";
        return true;
    }

    return false;
};

/**
 *
 * Login Validation Controller
 *
 */
const validate_email_login = (email_login) => {
    const err_email_login =
        email_login.parentNode.querySelector(".invalid-feedback");

    if (email_login.length === 0) {
        email_login.classList.remove("is-valid");
        email_login.classList.add("is-invalid");
        err_email_login.innerText = "Email is required";
    } else if (
        !email_login.match(
            /^[a-zA-Z0-9._-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)+(?:\.[a-zA-Z0-9-]+)*$/g
        )
    ) {
        email_login.classList.remove("is-valid");
        email_login.classList.add("is-invalid");
        err_email_login.innerText = "Email is not valid";
    } else {
        email_login.classList.remove("is-invalid");
        email_login.classList.add("is-valid");
        err_email_login.innerText = "";
        return true;
    }

    return false;
};

const validate_utype_login = (utype_login) => {
    const err_utype_login =
        utype_login.parentNode.querySelector(".invalid-feedback");

    if (utype_login.length === 0) {
        utype_login.classList.remove("is-valid");
        utype_login.classList.add("is-invalid");
        err_utype_login.innerText = "User Type is required";
    } else if (!utype_login.match(/(doctor|patient|emanager)/g)) {
        utype_login.classList.remove("is-valid");
        utype_login.classList.add("is-invalid");
        err_utype_login.innerText = "User Type is invalid";
    } else {
        utype_login.classList.remove("is-invalid");
        utype_login.classList.add("is-valid");
        err_utype_login.innerText = "";
        return true;
    }

    return false;
};

const validate_rememberme_login = (rememberme_login) => {
    const err_rememberme_login =
        rememberme_login.parentNode.querySelector(".invalid-feedback");

    if (!rememberme_login && !rememberme_login.match(/(on|off)/g)) {
        rememberme_login.classList.remove("is-valid");
        rememberme_login.classList.add("is-invalid");
        err_rememberme_login.innerText = "Remember me value is invalid";
    } else {
        rememberme_login.classList.remove("is-invalid");
        rememberme_login.classList.add("is-valid");
        err_rememberme_login.innerText = "";
        return true;
    }

    return false;
};

function initialize() {
    // enable darkmode if cookie exist
    if (getCookie("darkmode") === "true") {
        setCookie("darkmode", "true", 365);
        DarkReader.enable();
    } else {
        setCookie("darkmode", "false", 365);
        DarkReader.disable();
    }
}
