<?php

/**
 * Can't access directly by URL
 */

defined("_DIRECT_ACCESS") or exit("<h1>Your are not allowed</h1>");
// define("_DIRECT_ACCESS", true);

require_once dirname(__FILE__, 3) . "/helper/functions.php";

require_once _ROOT_DIR . "models/Model.php";
require_once _ROOT_DIR . "models/Patient/Patient.php";

class PatientModel extends Model
{
    public static function authUser(string $p_email, string $p_password)
    {
        $query = "SELECT * FROM view_patients WHERE p_email = :p_email";

        $results = parent::get(
            $query,
            [
                ":p_email"          => $p_email
            ]
        );

        return count($results) > 0 && password_verify($p_password, $results[0]['p_password']) ? $results[0] : null;
    }

    public static function isDuplicateEmail(string $email)
    {
        $query = "SELECT * FROM view_patients WHERE p_email = :p_email";

        $results = parent::get(
            $query,
            [
                ":p_email"          => $email
            ]
        );

        return count($results) > 0 ? true : false;
    }

    public static function getUserByEmail(string $p_email)
    {
        $query = "SELECT * FROM view_patients WHERE p_email = :p_email";

        $results = parent::get(
            $query,
            [
                ":p_email"          => $p_email
            ]
        );

        return count($results) > 0 ? $results[0] : null;
    }

    public static function createUser($patient)
    {
        $query = "CALL insert_patient(:p_name, :p_email, :p_phone, :p_password, :p_gender, :p_dob, :p_area, :p_subdistrict, :p_district, :p_division);";

        return parent::execute(
            $query,
            [
                ":p_name"           => $patient->getUName(),
                ":p_email"          => $patient->getUEmail(),
                ":p_phone"          => $patient->getUPhone(),
                ":p_password"       => $patient->getUPassword(),
                ":p_gender"         => $patient->getUGender(),
                ":p_dob"            => $patient->getUDob(),
                ":p_area"           => $patient->getPArea(),
                ":p_subdistrict"    => $patient->getPSubdistrict(),
                ":p_district"       => $patient->getPDistrict(),
                ":p_division"       => $patient->getPDivision(),
            ]
        );
    }

    public static function updateUser($patient)
    {
        $query = "CALL update_patient(:p_id, :p_name, :p_email, :p_phone, :p_gender, :p_dob, :p_area, :p_subdistrict, :p_district, :p_division);";

        return parent::execute(
            $query,
            [
                ":p_id"             => $patient->getPId(),
                ":p_name"           => $patient->getUName(),
                ":p_email"          => $patient->getUEmail(),
                ":p_phone"          => $patient->getUPhone(),
                ":p_gender"         => $patient->getUGender(),
                ":p_dob"            => $patient->getUDob(),
                ":p_area"           => $patient->getPArea(),
                ":p_subdistrict"    => $patient->getPSubdistrict(),
                ":p_district"       => $patient->getPDistrict(),
                ":p_division"       => $patient->getPDivision(),
            ]
        );
    }

    public static function deleteUser(int $patient_id)
    {
        $query = "CALL delete_patient(:p_id);";

        return parent::execute(
            $query,
            [
                ":p_id"          => $patient_id
            ]
        );
    }

    public static function getAllDoctors($name = "", $email = "")
    {
        if (empty($name) && !empty($email)) {
            $query = "SELECT * FROM view_doctors WHERE d_email = :d_email";

            return parent::get(
                $query,
                [
                    ":d_email"     => "$email"
                ]
            );
        } else if (empty($email) && !empty($name)) {
            $query = "SELECT * FROM view_doctors WHERE d_name LIKE :d_name";

            return parent::get(
                $query,
                [
                    ":d_name"      => "%$name%"
                ]
            );
        } else if (!empty($email) && !empty($name)) {
            $query = "SELECT * FROM view_doctors WHERE d_name LIKE :d_name AND d_email = :d_email";

            return parent::get(
                $query,
                [
                    ":d_name"      => "%$name%",
                    ":d_email"     => "$email"
                ]
            );
        } else {
            $query = "SELECT * FROM view_doctors WHERE d_name LIKE :d_name OR d_email = :d_email";

            return parent::get(
                $query,
                [
                    ":d_name"      => "%$name%",
                    ":d_email"     => "$email"
                ]
            );
        }
    }

    public static function getAllHospitals($name = "", $email = "")
    {
        if (empty($name) && !empty($email)) {
            $query = "SELECT * FROM view_hospitals WHERE h_email = :h_email";

            return parent::get(
                $query,
                [
                    ":h_email"     => $email
                ]
            );
        } else if (!empty($name) && empty($email)) {
            $query = "SELECT * FROM view_hospitals WHERE h_name LIKE :h_name";

            return parent::get(
                $query,
                [
                    ":h_name"      => "%$name%"
                ]
            );
        } else if (!empty($email) && !empty($name)) {
            $query = "SELECT * FROM view_hospitals WHERE h_name LIKE :h_name AND h_email = :h_email";

            return parent::get(
                $query,
                [
                    ":h_name"      => "%$name%",
                    ":h_email"     => $email
                ]
            );
        } else {
            $query = "SELECT * FROM view_hospitals WHERE 1";

            return parent::get($query);
        }
    }

    public static function requestAppointment($reason, $d_id, $p_id)
    {
        $query = "CALL insert_appointment(:reason, :d_id, :p_id);";

        return parent::execute(
            $query,
            [
                ":reason"         => $reason,
                ":d_id"           => $d_id,
                ":p_id"           => $p_id
            ]
        );
    }
}

// _var_dump(PatientModel::isDuplicateEmail('khuko@patient.com'));
// $temp_patient = new Patient();

// CALL insert_patient('Mohib', 'mohib@patient.com', '+8801686749023', 'asd@#123', 'male', '2021-12-22', 'Ashkona', 'Uttara', 'Dhaka', 'Dhaka');

// $temp_patient->setUName('Mohibor');
// $temp_patient->setUEmail('mohibor@patient.com');
// $temp_patient->setUPhone('+880163497503');
// $temp_patient->setUPassword('asd@123');
// $temp_patient->setUGender('male');
// $temp_patient->setUDob('2021-12-22');
// $temp_patient->setPArea('Ashkona');
// $temp_patient->setPSubdistrict('Uttara');
// $temp_patient->setPDistrict('Dhaka');
// $temp_patient->setPDivision('Dhaka');

// _var_dump(PatientModel::createUser($temp_patient));

// _var_dump(PatientModel::getAllDoctors("df", ""));