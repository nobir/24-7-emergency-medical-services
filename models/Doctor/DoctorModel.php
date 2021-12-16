<?php

/**
 * Can't access directly by URL
 */

defined("_DIRECT_ACCESS") or exit("<h1>Your are not allowed</h1>");
// define("_DIRECT_ACCESS", true);

require_once dirname(__FILE__, 3) . "/helper/functions.php";

require_once _ROOT_DIR . "models/Model.php";
require_once _ROOT_DIR . "models/Doctor/Doctor.php";

class DoctorModel extends Model
{
    public static function authUser(string $d_email, string $d_password)
    {
        $query = "SELECT * FROM view_doctors WHERE d_email = :d_email";

        $results = parent::get(
            $query,
            [
                ":d_email"          => $d_email
            ]
        );

        return count($results) > 0 && password_verify($d_password, $results[0]['d_password']) ? $results[0] : null;
    }

    public static function isDuplicateEmail(string $email)
    {
        $query = "SELECT * FROM view_doctors WHERE d_email = :d_email";

        $results = parent::get(
            $query,
            [
                ":d_email"          => $email
            ]
        );

        return count($results) > 0 ? true : false;
    }

    public static function getUserByEmail(string $d_email)
    {
        $query = "SELECT * FROM view_doctors WHERE d_email = :d_email";

        $results = parent::get(
            $query,
            [
                ":d_email"          => $d_email
            ]
        );

        return count($results) > 0 ? $results[0] : null;
    }

    public static function createUser($doctor)
    {
        $query = "CALL insert_doctor(:d_name, :d_email, :d_phone, :d_password, :d_gender, :d_dob, :d_area, :d_subdistrict, :d_district, :d_division);";

        return parent::execute(
            $query,
            [
                ":d_name"           => $doctor->getUName(),
                ":d_email"          => $doctor->getUEmail(),
                ":d_phone"          => $doctor->getUPhone(),
                ":d_password"       => $doctor->getUPassword(),
                ":d_gender"         => $doctor->getUGender(),
                ":d_dob"            => $doctor->getUDob(),
                ":d_area"           => $doctor->getDArea(),
                ":d_subdistrict"    => $doctor->getDSubdistrict(),
                ":d_district"       => $doctor->getDDistrict(),
                ":d_division"       => $doctor->getDDivision(),
            ]
        );
    }

    public static function updateUser($doctor)
    {
        $query = "CALL update_doctor(:d_id, :d_name, :d_email, :d_phone, :d_gender, :d_dob, :d_degree, :d_specialization, :d_schedule, :d_area, :d_subdistrict, :d_district, :d_division);";

        return parent::execute(
            $query,
            [
                ":d_id"             => $doctor->getDId(),
                ":d_name"           => $doctor->getUName(),
                ":d_email"          => $doctor->getUEmail(),
                ":d_phone"          => $doctor->getUPhone(),
                ":d_gender"         => $doctor->getUGender(),
                ":d_dob"            => $doctor->getUDob(),
                ":d_degree"         => $doctor->getDDegree(),
                ":d_specialization" => $doctor->getDSpecialization(),
                ":d_schedule"       => $doctor->getDSchedule(),
                ":d_area"           => $doctor->getDArea(),
                ":d_subdistrict"    => $doctor->getDSubdistrict(),
                ":d_district"       => $doctor->getDDistrict(),
                ":d_division"       => $doctor->getDDivision(),
            ]
        );
    }

    public static function deleteUser(int $doctor_id)
    {
        $query = "CALL delete_doctor(:d_id);";

        return parent::execute(
            $query,
            [
                ":d_id"          => $doctor_id
            ]
        );
    }

    public static function getAppointments(int $d_id, $name = "", $email = "")
    {
        if (empty($name) && !empty($email)) {
            $query = "SELECT * FROM view_appointmets WHERE (d_id = :d_id AND ap_status = -1) AND p_email = :p_email";

            return parent::get(
                $query,
                [
                    ":p_email"      => $email,
                    ":d_id"         => $d_id
                ]
            );
        } else if (!empty($name) && empty($email)) {
            $query = "SELECT * FROM view_appointmets WHERE (d_id = :d_id AND ap_status = -1) AND p_name LIKE :p_name";

            return parent::get(
                $query,
                [
                    ":p_name"       => "%$name%",
                    ":d_id"         => $d_id
                ]
            );
        } else if (!empty($email) && !empty($name)) {
            $query = "SELECT * FROM view_appointmets WHERE (d_id = :d_id AND ap_status = -1) AND (p_name LIKE :p_name AND p_email = :p_email)";

            return parent::get(
                $query,
                [
                    ":p_name"       => "%$name%",
                    ":p_email"      => $email,
                    ":d_id"         => $d_id
                ]
            );
        } else {
            $query = "SELECT * FROM view_appointmets WHERE (d_id = :d_id AND ap_status = -1)";

            return parent::get(
                $query,
                [
                    ":d_id"         => $d_id
                ]
            );
        }
    }

    public static function getAllAppointments(int $d_id)
    {
        $query = "SELECT * FROM view_appointmets WHERE d_id = :d_id AND ap_status = -1";

        return parent::get(
            $query,
            [
                ":d_id"          => $d_id
            ]
        );
    }

    public static function getAllAppointmentHistopy(int $d_id)
    {
        $query = "SELECT * FROM view_appointmets WHERE d_id = :d_id AND ap_status != -1";

        return parent::get(
            $query,
            [
                ":d_id"          => $d_id
            ]
        );
    }

    public static function rejectAppointment(int $ap_id)
    {
        $query = "UPDATE ems_appointments SET ap_status = 0 WHERE ap_id = :ap_id";

        return parent::execute(
            $query,
            [
                ":ap_id"         => $ap_id
            ]
        );
    }

    public static function acceptAppointment(int $ap_id)
    {
        $query = "UPDATE ems_appointments SET ap_status = 1 WHERE ap_id = :ap_id";

        return parent::execute(
            $query,
            [
                ":ap_id"         => $ap_id
            ]
        );
    }
}

// _var_dump(DoctorModel::isDuplicateEmail('mohib@doctor.com'));
// $temp_doctor = new Doctor();

// CALL insert_doctor('Mohib', 'mohib@doctor.com', '+8801686749023', 'asd@#123', 'male', '2021-12-22', 'Ashkona', 'Uttara', 'Dhaka', 'Dhaka');

// $temp_doctor->setUName('Mohibor');
// $temp_doctor->setUEmail('mohibor@doctor.com');
// $temp_doctor->setUPhone('+880163497503');
// $temp_doctor->setUPassword('asd@123');
// $temp_doctor->setUGender('male');
// $temp_doctor->setUDob('2021-12-22');
// $temp_doctor->setDArea('Ashkona');
// $temp_doctor->setDSubdistrict('Uttara');
// $temp_doctor->setDDistrict('Dhaka');
// $temp_doctor->setDDivision('Dhaka');

// _var_dump(DoctorModel::createUser($temp_doctor));