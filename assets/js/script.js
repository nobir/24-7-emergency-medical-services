"use strict";

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

const confirmDelete = (delete_button) => {
    if (delete_button) {
        if (confirm("Are you sure you want to delete the user?")) {
            return true;
        } else {
            return false;
        }
    }
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

document.addEventListener("DOMContentLoaded", () => {
    initialize();

    const form = getElemById("deleteuserform");
    // const canvasmenu = getElemById("canvasmenu");
    const delete_button = getElemById("deleteuser");
    const dark_mode_1_button = getElemById("dark_mode_1");
    const dark_mode_2_button = getElemById("dark_mode_2");

    if (delete_button) {
        delete_button.addEventListener("click", (e) => {
            e.preventDefault();

            if (confirm("Are you sure you want to delete ?")) {
                form.submit();
            }
        });
    }

    toggleDarkMode(dark_mode_1_button);
    toggleDarkMode(dark_mode_2_button);
});
