--
-- Create Database
--

DROP DATABASE IF EXISTS ems;
CREATE DATABASE ems;

--
-- Select database
--

USE ems;

--
-- Tables
--

--
-- ems_users
--

CREATE TABLE ems_users(
    u_id INT(10) NOT NULL AUTO_INCREMENT,
    u_name VARCHAR(100) NOT NULL,
    u_email VARCHAR(50) NOT NULL,
    u_phone VARCHAR(20) NOT NULL,
    u_password VARCHAR(255) NOT NULL,
    u_gender VARCHAR(10) NOT NULL,
    u_dob VARCHAR(20) NOT NULL,
    u_type VARCHAR(10) NOT NULL,
    u_pp_path VARCHAR(255) NOT NULL DEFAULT '',
    PRIMARY KEY(u_id)
);

--
-- ems_addresses
--

CREATE TABLE ems_addresses(
    ad_id INT(10) NOT NULL AUTO_INCREMENT,
    ad_area VARCHAR(255) NOT NULL DEFAULT '',
    ad_subdistrict VARCHAR(50) NOT NULL DEFAULT '',
    ad_district VARCHAR(50) NOT NULL DEFAULT '',
    ad_division VARCHAR(50) NOT NULL DEFAULT '',
    PRIMARY KEY(ad_id)
);

--
-- ems_admins
--

CREATE TABLE ems_admins(
    a_id INT(10) NOT NULL AUTO_INCREMENT,
    u_id INT(10) NOT NULL,
    PRIMARY KEY(a_id)
);

CREATE TABLE ems_patients(
    p_id INT(10) NOT NULL AUTO_INCREMENT,
    u_id INT(10) NOT NULL,
    ad_id INT(10) NOT NULL,
    PRIMARY KEY(p_id)
);

--
-- ems_doctors
--

CREATE TABLE ems_doctors(
    d_id INT(10) NOT NULL AUTO_INCREMENT,
    d_degree VARCHAR(100) NOT NULL DEFAULT '',
    d_specialization VARCHAR(100) NOT NULL DEFAULT '',
    d_schedule VARCHAR(255) NOT NULL DEFAULT '',
    d_verify INT(2) NOT NULL DEFAULT '0',
    u_id INT(10) NOT NULL,
    ad_id INT(10) NOT NULL,
    PRIMARY KEY(d_id)
);

--
-- ems_emanagers
--

CREATE TABLE ems_emanagers(
    em_id INT(10) NOT NULL AUTO_INCREMENT,
    em_work_subdistrict VARCHAR(50) NOT NULL,
    u_id INT(10) NOT NULL,
    ad_id INT(10) NOT NULL,
    PRIMARY KEY(em_id)
);

--
-- ems_hospitals
--

CREATE TABLE ems_hospitals(
    h_id INT(10) NOT NULL AUTO_INCREMENT,
    h_name VARCHAR(255) NOT NULL,
    h_email VARCHAR(50) NOT NULL,
    h_phone VARCHAR(20) NOT NULL,
    ad_id INT(10) NOT NULL,
    PRIMARY KEY(h_id)
);

--
-- ems_ambulances
--

CREATE TABLE ems_ambulances(
    am_id INT(10) NOT NULL AUTO_INCREMENT,
    am_phone VARCHAR(20) NOT NULL,
    ad_id INT(10) NOT NULL,
    PRIMARY KEY(am_id)
);

--
-- ems_appointments
--
CREATE TABLE ems_appointments(
    ap_id INT(10) NOT NULL AUTO_INCREMENT,
    ap_reason VARCHAR(255) NOT NULL,
    ap_status INT(3) NOT NULL DEFAULT '-1',
    d_id INT(10) NOT NULL,
    p_id INT(10) NOT NULL,
    PRIMARY KEY(ap_id)
);

--
-- Foreign Key
--

ALTER TABLE
    ems_admins ADD CONSTRAINT fk_admins_users FOREIGN KEY(u_id) REFERENCES ems_users(u_id) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE
    ems_patients ADD CONSTRAINT fk_patients_users FOREIGN KEY(u_id) REFERENCES ems_users(u_id) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE
    ems_patients ADD CONSTRAINT fk_patients_addresses FOREIGN KEY(ad_id) REFERENCES ems_addresses(ad_id) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE
    ems_doctors ADD CONSTRAINT fk_doctors_users FOREIGN KEY(u_id) REFERENCES ems_users(u_id) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE
    ems_doctors ADD CONSTRAINT fk_doctors_addresses FOREIGN KEY(ad_id) REFERENCES ems_addresses(ad_id) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE
    ems_emanagers ADD CONSTRAINT fk_emanagers_users FOREIGN KEY(u_id) REFERENCES ems_users(u_id) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE
    ems_emanagers ADD CONSTRAINT fk_emanagers_addresses FOREIGN KEY(ad_id) REFERENCES ems_addresses(ad_id) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE
    ems_hospitals ADD CONSTRAINT fk_hopitals_addresses FOREIGN KEY(ad_id) REFERENCES ems_addresses(ad_id) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE
    ems_ambulances ADD CONSTRAINT fk_ambulances_addresses FOREIGN KEY(ad_id) REFERENCES ems_addresses(ad_id) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE
    ems_appointments ADD CONSTRAINT fk_appointments_doctors FOREIGN KEY(d_id) REFERENCES ems_doctors(d_id) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE
    ems_appointments ADD CONSTRAINT fk_appointments_patients FOREIGN KEY(p_id) REFERENCES ems_patients(p_id) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Views
--

--
-- Admins
--

CREATE OR REPLACE VIEW view_admins AS(
    SELECT
        a.a_id "a_id",
        u.u_id "u_id",
        u.u_name "a_name",
        u.u_email "a_email",
        u.u_phone "a_phone",
        u.u_password "a_password",
        u.u_gender "a_gender",
        u.u_dob "a_dob",
        u.u_type "utype",
        u.u_pp_path "a_pp_path"
    FROM
        ems_users u,
        ems_admins a
    WHERE
        u.u_id = a.u_id
    ORDER BY
        a.a_id
);

--
-- Patients
--

CREATE OR REPLACE VIEW view_patients AS(
    SELECT
        p.p_id "p_id",
        u.u_id "u_id",
        ad.ad_id "ad_id",
        u.u_name "p_name",
        u.u_email "p_email",
        u.u_phone "p_phone",
        u.u_password "p_password",
        u.u_gender "p_gender",
        u.u_dob "p_dob",
        u.u_type "utype",
        u.u_pp_path "p_pp_path",
        ad.ad_area "p_area",
        ad.ad_subdistrict "p_subdistrict",
        ad.ad_district "p_district",
        ad.ad_division "p_division"
    FROM
        ems_users u,
        ems_addresses ad,
        ems_patients p
    WHERE
        u.u_id = p.u_id AND ad.ad_id = p.ad_id
    ORDER BY
        p.p_id
);

--
-- Doctors
--

CREATE OR REPLACE VIEW view_doctors AS(
    SELECT
        d.d_id "d_id",
        u.u_id "u_id",
        ad.ad_id "ad_id",
        u.u_name "d_name",
        u.u_email "d_email",
        u.u_phone "d_phone",
        u.u_password "d_password",
        u.u_gender "d_gender",
        u.u_dob "d_dob",
        u.u_type "utype",
        u.u_pp_path "d_pp_path",
        d.d_degree "d_degree",
        d.d_specialization "d_specialization",
        d.d_schedule "d_schedule",
        d.d_verify "d_verify",
        ad.ad_area "d_area",
        ad.ad_subdistrict "d_subdistrict",
        ad.ad_district "d_district",
        ad.ad_division "d_division"
    FROM
        ems_users u,
        ems_addresses ad,
        ems_doctors d
    WHERE
        u.u_id = d.u_id AND ad.ad_id = d.ad_id
    ORDER BY
        d.d_id
);

--
-- Emanagers
--

CREATE OR REPLACE VIEW view_emanagers AS(
    SELECT
        em.em_id "em_id",
        u.u_id "u_id",
        ad.ad_id "ad_id",
        u.u_name "em_name",
        u.u_email "em_email",
        u.u_phone "em_phone",
        u.u_password "em_password",
        u.u_gender "em_gender",
        u.u_dob "em_dob",
        u.u_type "utype",
        u.u_pp_path "em_pp_path",
        em.em_work_subdistrict "em_work_subdistrict",
        ad.ad_area "em_area",
        ad.ad_subdistrict "em_subdistrict",
        ad.ad_district "em_district",
        ad.ad_division "em_division"
    FROM
        ems_users u,
        ems_addresses ad,
        ems_emanagers em
    WHERE
        u.u_id = em.u_id AND ad.ad_id = em.ad_id
    ORDER BY
        em.em_id
);

--
-- Hospitals
--

CREATE OR REPLACE VIEW view_hospitals AS(
    SELECT
        h.h_id "h_id",
        ad.ad_id "ad_id",
        h.h_name "h_name",
        h.h_email "h_email",
        h.h_phone "h_phone",
        ad.ad_area "h_area",
        ad.ad_subdistrict "h_subdistrict",
        ad.ad_district "h_district",
        ad.ad_division "h_division"
    FROM
        ems_addresses ad,
        ems_hospitals h
    WHERE
        ad.ad_id = h.ad_id
    ORDER BY
        h.h_id
);

--
-- Ambulances
--

CREATE OR REPLACE VIEW view_ambulances AS(
    SELECT
        am.am_id "am_id",
        ad.ad_id "ad_id",
        am.am_phone "am_phone",
        ad.ad_area "am_area",
        ad.ad_subdistrict "am_subdistrict",
        ad.ad_district "am_district",
        ad.ad_division "am_division"
    FROM
        ems_addresses ad,
        ems_ambulances am
    WHERE
        ad.ad_id = am.ad_id
    ORDER BY
        am.am_id
);

--
-- Appointmets
--

CREATE OR REPLACE VIEW view_appointmets AS(
    SELECT
        ap.ap_id "ap_id",
        d.d_id "d_id",
        p.p_id "p_id",
        ap.ap_reason "ap_reason",
        ap.ap_status "ap_status",
        d.u_id "d_u_id",
        d.ad_id "d_ad_id",
        d.d_name "d_name",
        d.d_email "d_email",
        d.d_phone "d_phone",
        d.d_password "d_password",
        d.d_gender "d_gender",
        d.d_dob "d_dob",
        d.utype "d_utype",
        d.d_pp_path "d_pp_path",
        d.d_degree "d_degree",
        d.d_specialization "d_specialization",
        d.d_schedule "d_schedule",
        d.d_verify "d_verify",
        d.d_area "d_area",
        d.d_subdistrict "d_subdistrict",
        d.d_district "d_district",
        d.d_division "d_division",
        p.u_id "p_u_id",
        p.ad_id "p_ad_id",
        p.p_name "p_name",
        p.p_email "p_email",
        p.p_phone "p_phone",
        p.p_password "p_password",
        p.p_gender "p_gender",
        p.p_dob "p_dob",
        p.utype "p_utype",
        p.p_pp_path "p_pp_path",
        p.p_area "p_area",
        p.p_subdistrict "p_subdistrict",
        p.p_district "p_district",
        p.p_division "p_division"
    FROM
        view_doctors d,
        view_patients p,
        ems_appointments ap
    WHERE
        d.d_id = ap.d_id AND p.p_id = ap.p_id
    ORDER BY
        ap.ap_id
);

--
-- Procedures
--

--
-- Insert Admin
--

DELIMITER
    $$
CREATE OR REPLACE PROCEDURE insert_admin(
    IN a_name VARCHAR(100),
    IN a_email VARCHAR(50),
    IN a_phone VARCHAR(20),
    IN a_password VARCHAR(255),
    IN a_gender VARCHAR(10),
    IN a_dob VARCHAR(20)
)
BEGIN
    INSERT INTO ems_users(u_id, u_name, u_email, u_phone, u_password, u_gender, u_dob, u_type, u_pp_path) VALUES(NULL, a_name, a_email, a_phone, a_password, a_gender, a_dob, 'admin', '');
    INSERT INTO ems_admins(a_id, u_id) VALUES(NULL, LAST_INSERT_ID());
END $$
DELIMITER
    ;

CALL insert_admin('Nobir Hossain', 'nobir@admin.com', '+8801628967403', '$2y$10$m6iVX0kCncC7XSwGxt7irO8fGLkFAaZu6KrmkbicLpbtF6jqBX0Ge', 'male', '2021-12-22');

--
-- Update Admin
--

DELIMITER
    $$
CREATE OR REPLACE PROCEDURE update_admin(
    IN admin_id int(10),
    IN admin_name VARCHAR(100),
    IN admin_email VARCHAR(50),
    IN admin_phone Varchar(20),
    IN admin_gender VARCHAR(10),
    IN admin_dob VARCHAR(20)
)
BEGIN

    SET @user_id := (SELECT u_id FROM view_admins WHERE a_id = admin_id);

    UPDATE ems_users SET u_name = admin_name, u_email = admin_email, u_phone = admin_phone, u_gender = admin_gender, u_dob = admin_dob WHERE u_id = @user_id;
END $$
DELIMITER
    ;

-- CALL update_admin(1, 'Admin Name Updated', 'admin@update.com', '+88012345678910', 'female', '2021-09-24');

--
-- Delete Admin
--

DELIMITER
    $$
CREATE OR REPLACE PROCEDURE delete_admin(IN admin_id INT(10))
BEGIN
    SET @user_id = (SELECT u_id FROM ems_admins WHERE a_id = admin_id);

    DELETE FROM ems_users WHERE u_id = @user_id;
    DELETE FROM ems_admins WHERE a_id = admin_id;
END $$
DELIMITER
    ;

-- CALL delete_admin(1);

--
-- Insert Patients
--

DELIMITER
    $$
CREATE OR REPLACE PROCEDURE insert_patient(
    IN p_name VARCHAR(100),
    IN p_email VARCHAR(50),
    IN p_phone VARCHAR(20),
    IN p_password VARCHAR(255),
    IN p_gender VARCHAR(10),
    IN p_dob VARCHAR(20),
    IN p_area VARCHAR(255),
    IN p_subdistrict VARCHAR(50),
    IN p_district VARCHAR(50),
    IN p_division VARCHAR(50)
)
BEGIN
    INSERT INTO ems_users(u_id, u_name, u_email, u_phone, u_password, u_gender, u_dob, u_type, u_pp_path) VALUES(NULL, p_name, p_email, p_phone, p_password, p_gender, p_dob, 'patient', '');
    SET @user_id = LAST_INSERT_ID();

    INSERT ems_addresses(ad_id, ad_area, ad_subdistrict, ad_district, ad_division) VALUES(NULL, p_area, p_subdistrict, p_district, p_division);
    SET @address_id = LAST_INSERT_ID();

    INSERT INTO ems_patients(p_id, u_id, ad_id) VALUES(NULL, @user_id, @address_id);
END $$
DELIMITER
    ;

CALL insert_patient('Khuko Moni', 'khuko@patient.com', '+8801667402389', '$2y$10$m6iVX0kCncC7XSwGxt7irO8fGLkFAaZu6KrmkbicLpbtF6jqBX0Ge', 'female', '2021-12-22', 'Mishonpara', 'Chashara', 'Narayanganj', 'Dhaka');

--
-- Update Patient
--

DELIMITER
    $$
CREATE OR REPLACE PROCEDURE update_patient(
    IN patient_id INT(10),
    IN patient_name VARCHAR(100),
    IN patient_email VARCHAR(50),
    IN patient_phone VARCHAR(20),
    IN patient_gender VARCHAR(10),
    IN patient_dob VARCHAR(20),
    IN patient_area VARCHAR(255),
    IN patient_subdistrict VARCHAR(50),
    IN patient_district VARCHAR(50),
    IN patient_division VARCHAR(50)
)
BEGIN

    SET @user_id := (SELECT u_id FROM view_patients WHERE p_id = patient_id);
    SET @address_id := (SELECT ad_id FROM view_patients WHERE p_id = patient_id);

    UPDATE ems_users SET u_name = patient_name, u_email = patient_email, u_phone = patient_phone, u_gender = patient_gender, u_dob = patient_dob WHERE u_id = @user_id;
    UPDATE ems_addresses SET ad_area = patient_area, ad_subdistrict = patient_district, ad_district = patient_division, ad_division = patient_division WHERE ad_id = @address_id;

END $$
DELIMITER
    ;

-- CALL update_patient(1, 'Kakashi Uchiha', 'kakashi@uchiha.com', '+8801627388394', 'female', '2021-09-24', 'Kakashi area 1 update', 'Kakashi sub district 1 update', 'Kakashi district 1 update', 'Kakashi division 1 update');


--
-- Delete Patient
--

DELIMITER
    $$
CREATE OR REPLACE PROCEDURE delete_patient(IN patient_id INT(10))
BEGIN
    SET @user_id = (SELECT u_id FROM ems_patients WHERE p_id = patient_id);
    SET @addresse_id = (SELECT ad_id FROM ems_patients WHERE p_id = patient_id);

    DELETE FROM ems_users WHERE u_id = @user_id;
    DELETE FROM ems_addresses WHERE ad_id = @addresse_id;
    DELETE FROM ems_patients WHERE p_id = patient_id;
END $$
DELIMITER
    ;

-- CALL delete_patient(1);

--
-- Insert Doctors
--

DELIMITER
    $$
CREATE OR REPLACE PROCEDURE insert_doctor(
    IN d_name VARCHAR(100),
    IN d_email VARCHAR(50),
    IN d_phone VARCHAR(20),
    IN d_password VARCHAR(255),
    IN d_gender VARCHAR(10),
    IN d_dob VARCHAR(20),
    IN d_area VARCHAR(255),
    IN d_subdistrict VARCHAR(50),
    IN d_district VARCHAR(50),
    IN d_division VARCHAR(50)
)
BEGIN
    INSERT INTO ems_users(u_id, u_name, u_email, u_phone, u_password, u_gender, u_dob, u_type, u_pp_path) VALUES(NULL, d_name, d_email, d_phone, d_password, d_gender, d_dob, 'doctor', '');
    SET @user_id = LAST_INSERT_ID();

    INSERT ems_addresses(ad_id, ad_area, ad_subdistrict, ad_district, ad_division) VALUES(NULL, d_area, d_subdistrict, d_district, d_division);
    SET @address_id = LAST_INSERT_ID();

    INSERT INTO ems_doctors(d_id, d_degree, d_specialization, d_schedule, d_verify, u_id, ad_id) VALUES(NULL, '', '', '', 0, @user_id, @address_id);
END $$
DELIMITER
    ;

CALL insert_doctor('Mohib', 'mohib@doctor.com', '+8801686749023', '$2y$10$m6iVX0kCncC7XSwGxt7irO8fGLkFAaZu6KrmkbicLpbtF6jqBX0Ge', 'male', '2021-12-22', 'Ashkona', 'Uttara', 'Dhaka', 'Dhaka');

UPDATE ems_doctors SET d_verify = 1 WHERE d_id = 1;

--
-- Update Doctor
--

DELIMITER
    $$
CREATE OR REPLACE PROCEDURE update_doctor(
    IN doctor_id INT(10),
    IN doctor_name VARCHAR(100),
    IN doctor_email VARCHAR(50),
    IN doctor_phone VARCHAR(20),
    IN doctor_gender VARCHAR(10),
    IN doctor_dob VARCHAR(20),
    IN doctor_degree VARCHAR(100),
    IN doctor_specialization VARCHAR(100),
    IN doctor_schedule VARCHAR(255),
    IN doctor_area VARCHAR(255),
    IN doctor_subdistrict VARCHAR(50),
    IN doctor_district VARCHAR(50),
    IN doctor_division VARCHAR(50)
)
BEGIN

    SET @user_id := (SELECT u_id FROM view_doctors WHERE d_id = doctor_id);
    SET @address_id := (SELECT ad_id FROM view_doctors WHERE d_id = doctor_id);

    UPDATE ems_users SET u_name = doctor_name, u_email = doctor_email, u_phone = doctor_phone, u_gender = doctor_gender, u_dob = doctor_dob WHERE u_id = @user_id;
    UPDATE ems_addresses SET ad_area = doctor_area, ad_subdistrict = doctor_district, ad_district = doctor_division, ad_division = doctor_division WHERE ad_id = @address_id;
    UPDATE ems_doctors SET d_degree = doctor_degree, d_specialization = doctor_specialization, d_schedule = doctor_schedule WHERE d_id = doctor_id;

END $$
DELIMITER
    ;

-- CALL update_doctor(1, 'Kakashi Uchiha', 'kakashi@uchiha.com', '+8801627388394', 'female', '2021-09-24', 'MBBS', 'Cardiologist', 'Mon - Tues 09:00am - 05:00pm', 'Kakashi area 1 update', 'Kakashi sub district 1 update', 'Kakashi district 1 update', 'Kakashi division 1 update');

--
-- Delete Doctor
--

DELIMITER
    $$
CREATE OR REPLACE PROCEDURE delete_doctor(IN doctor_id INT(10))
BEGIN
    SET @user_id = (SELECT u_id FROM ems_doctors WHERE d_id = doctor_id);
    SET @addresse_id = (SELECT ad_id FROM ems_doctors WHERE d_id = doctor_id);

    DELETE FROM ems_users WHERE u_id = @user_id;
    DELETE FROM ems_addresses WHERE ad_id = @addresse_id;
    DELETE FROM ems_doctors WHERE d_id = doctor_id;
END $$
DELIMITER
    ;

-- CALL delete_doctor(1);

--
-- Insert Emanagers
--

DELIMITER
    $$
CREATE OR REPLACE PROCEDURE insert_emanager(
    IN em_name VARCHAR(100),
    IN em_email VARCHAR(50),
    IN em_phone VARCHAR(20),
    IN em_password VARCHAR(255),
    IN em_gender VARCHAR(10),
    IN em_dob VARCHAR(20),
    IN em_area VARCHAR(255),
    IN em_subdistrict VARCHAR(50),
    IN em_district VARCHAR(50),
    IN em_division VARCHAR(50)
)
BEGIN
    INSERT INTO ems_users(u_id, u_name, u_email, u_phone, u_password, u_gender, u_dob, u_type, u_pp_path) VALUES(NULL, em_name, em_email, em_phone, em_password, em_gender, em_dob, 'emanager', '');
    SET @user_id = LAST_INSERT_ID();

    INSERT ems_addresses(ad_id, ad_area, ad_subdistrict, ad_district, ad_division) VALUES(NULL, em_area, em_subdistrict, em_district, em_division);
    SET @address_id = LAST_INSERT_ID();

    INSERT INTO ems_emanagers(em_id, em_work_subdistrict, u_id, ad_id) VALUES(NULL, '', @user_id, @address_id);
END $$
DELIMITER
    ;

CALL insert_emanager('Munem Al', 'munem@emanager.com', '+8801689674023', '$2y$10$m6iVX0kCncC7XSwGxt7irO8fGLkFAaZu6KrmkbicLpbtF6jqBX0Ge', 'male', '2021-12-22', 'Moddho Paikepara', 'Mirpur', 'Dhaka', 'Dhaka');

--
-- Update Emanager
--

DELIMITER
    $$
CREATE OR REPLACE PROCEDURE update_emanager(
    IN emanager_id int(10),
    IN emanager_name VARCHAR(100),
    IN emanager_email VARCHAR(50),
    IN emanager_phone Varchar(20),
    IN emanager_gender VARCHAR(10),
    IN emanager_dob VARCHAR(20),
    IN emanager_work_subdistrict VARCHAR(50),
    IN emanager_area VARCHAR(255),
    IN emanager_subdistrict VARCHAR(50),
    IN emanager_district VARCHAR(50),
    IN emanager_division VARCHAR(50)
)
BEGIN

    SET @user_id := (SELECT u_id FROM view_emanagers WHERE em_id = emanager_id);
    SET @address_id := (SELECT ad_id FROM view_emanagers WHERE em_id = emanager_id);

    UPDATE ems_users SET u_name = emanager_name, u_email = emanager_email, u_phone = emanager_phone, u_gender = emanager_gender, u_dob = emanager_dob WHERE u_id = @user_id;
    UPDATE ems_addresses SET ad_area = emanager_area, ad_subdistrict = emanager_subdistrict, ad_district = emanager_division, ad_division = emanager_division WHERE ad_id = @address_id;
    UPDATE ems_emanagers SET em_work_subdistrict = emanager_work_subdistrict WHERE em_id = emanager_id;
END $$
DELIMITER
    ;
-- CALL update_emanager(1, 'Kakashi Uchiha', 'kakashi@uchiha.com', '+8801627388394', 'female', '2021-09-24', 'Mirpur work sub district', 'Kakashi area 1 update', 'Kakashi sub district 1 update', 'Kakashi district 1 update', 'Kakashi division 1 update');

--
-- Delete Emanager
--

DELIMITER
    $$
CREATE OR REPLACE PROCEDURE delete_emanager(IN emanager_id INT(10))
BEGIN
    SET @user_id = (SELECT u_id FROM ems_emanagers WHERE em_id = emanager_id);
    SET @addresse_id = (SELECT ad_id FROM ems_emanagers WHERE em_id = emanager_id);

    DELETE FROM ems_users WHERE u_id = @user_id;
    DELETE FROM ems_addresses WHERE ad_id = @addresse_id;
    DELETE FROM ems_emanagers WHERE em_id = emanager_id;
END $$
DELIMITER
    ;

-- CALL delete_emanager(1);

--
-- Insert Hospital
--

DELIMITER
    $$
CREATE OR REPLACE PROCEDURE insert_hospital(
    IN h_name VARCHAR(100),
    IN h_email VARCHAR(50),
    IN h_phone VARCHAR(20),
    IN h_area VARCHAR(255),
    IN h_subdistrict VARCHAR(50),
    IN h_district VARCHAR(50),
    IN h_division VARCHAR(50)
)
BEGIN
    INSERT ems_addresses(ad_id, ad_area, ad_subdistrict, ad_district, ad_division) VALUES(NULL, h_area, h_subdistrict, h_district, h_division);
    SET @address_id = LAST_INSERT_ID();

    INSERT INTO ems_hospitals(h_id, h_name, h_email, h_phone, ad_id) VALUES(NULL, h_name, h_email, h_phone, @address_id);
END $$
DELIMITER
    ;

CALL insert_hospital('Ar Raha Hospital', 'ar.raha@hospital.com', '+8801789456126','Ashkona', 'Uttara', 'Dhaka', 'Dhaka');

--
-- Update Hospital
--

DELIMITER
    $$
CREATE OR REPLACE PROCEDURE update_hospital(
    IN hospital_id INT(10),
    IN hospital_name VARCHAR(100),
    IN hospital_email VARCHAR(50),
    IN hospital_phone VARCHAR(20),
    IN hospital_area VARCHAR(255),
    IN hospital_subdistrict VARCHAR(50),
    IN hospital_district VARCHAR(50),
    IN hospital_division VARCHAR(50)
)
BEGIN
    SET @address_id := (SELECT ad_id FROM view_hospitals WHERE h_id = hospital_id);

    UPDATE ems_addresses SET ad_area = hospital_area, ad_subdistrict = hospital_subdistrict, ad_district = hospital_district, ad_division = hospital_division WHERE ad_id = @address_id;

    UPDATE ems_hospitals SET h_name = hospital_name, h_email = hospital_email, h_phone = hospital_phone WHERE h_id = hospital_id;

END $$
DELIMITER
    ;

--
-- Delete Hospital
--

DELIMITER
    $$
CREATE OR REPLACE PROCEDURE delete_hospital(IN hospital_id INT(10))
BEGIN
    SET @addresse_id = (SELECT ad_id FROM ems_hospitals WHERE h_id = hospital_id);

    DELETE FROM ems_addresses WHERE ad_id = @addresse_id;
    DELETE FROM ems_hospitals WHERE h_id = hospital_id;
END $$
DELIMITER
    ;

-- CALL delete_hospital(1);

--
-- Insert Ambulance
--

DELIMITER
    $$
CREATE OR REPLACE PROCEDURE insert_ambulance(
    IN am_phone VARCHAR(20),
    IN am_area VARCHAR(255),
    IN am_subdistrict VARCHAR(50),
    IN am_district VARCHAR(50),
    IN am_division VARCHAR(50)
)
BEGIN
    INSERT ems_addresses(ad_id, ad_area, ad_subdistrict, ad_district, ad_division) VALUES(NULL, am_area, am_subdistrict, am_district, am_division);
    SET @address_id = LAST_INSERT_ID();

    INSERT INTO ems_ambulances(am_id, am_phone, ad_id) VALUES(NULL, am_phone, @address_id);
END $$
DELIMITER
    ;

CALL insert_ambulance('+8801789456126','Sector 6', 'Uttara', 'Dhaka', 'Dhaka');

--
-- Update Ambulance
--

DELIMITER
    $$
CREATE OR REPLACE PROCEDURE update_ambulance(
    IN ambulance_id INT(10),
    IN ambulance_phone VARCHAR(20),
    IN ambulance_area VARCHAR(255),
    IN ambulance_subdistrict VARCHAR(50),
    IN ambulance_district VARCHAR(50),
    IN ambulance_division VARCHAR(50)
)
BEGIN
    SET @address_id := (SELECT ad_id FROM view_ambulances WHERE am_id = ambulance_id);

    UPDATE ems_addresses SET ad_area = ambulance_area, ad_subdistrict = ambulance_subdistrict, ad_district = ambulance_district, ad_division = ambulance_division WHERE ad_id = @address_id;

    UPDATE ems_ambulances SET am_phone = ambulance_phone WHERE am_id = ambulance_id;

END $$
DELIMITER
    ;


--
-- Delete Ambulance
--

DELIMITER
    $$
CREATE OR REPLACE PROCEDURE delete_ambulance(IN ambulance_id INT(10))
BEGIN
    SET @addresse_id = (SELECT ad_id FROM ems_ambulances WHERE am_id = ambulance_id);

    DELETE FROM ems_addresses WHERE ad_id = @addresse_id;
    DELETE FROM ems_ambulances WHERE am_id = ambulance_id;
END $$
DELIMITER
    ;

-- CALL delete_ambulance(1);

--
-- Insert Appointment
--

DELIMITER
    $$
CREATE OR REPLACE PROCEDURE insert_appointment(
    IN appointment_reason VARCHAR(255),
    IN d_id VARCHAR(10),
    IN p_id VARCHAR(10)
)
BEGIN
    INSERT INTO ems_appointments(ap_id, ap_reason, ap_status, d_id, p_id) VALUES(NULL, appointment_reason, -1, d_id, p_id);
END $$
DELIMITER
    ;

CALL insert_appointment('heart problem', 1, 1);

--
-- Delete Appointment
--

DELIMITER
    $$
CREATE OR REPLACE PROCEDURE delete_appointment(IN appointment_id INT(10))
BEGIN
    DELETE FROM ems_appointments WHERE ap_id = appointment_id;
END $$
DELIMITER
    ;

-- CALL delete_appointment(1);

COMMIT
    ;
