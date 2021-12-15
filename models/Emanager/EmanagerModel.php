<?php

/**
 * Can't access directly by URL
 */

defined("_DIRECT_ACCESS") or exit("<h1>Your are not allowed</h1>");

require_once dirname(__FILE__, 3) . "/helper/functions.php";

require_once _ROOT_DIR . "models/Model.php";
require_once _ROOT_DIR . "models/Emanager/Emanager.php";

class EmanagerModel extends Model
{
    public static function authUser(string $em_email, string $em_password)
    {
        $query = "SELECT * FROM view_emanagers WHERE em_email = :em_email";

        $results = parent::get(
            $query,
            [
                ":em_email"          => $em_email
            ]
        );

        return count($results) > 0 && password_verify($em_password, $results[0]['em_password']) ? $results[0] : null;
    }

    public static function isDuplicateEmail(string $email)
    {
        $query = "SELECT * FROM view_emanagers WHERE em_email = :em_email";

        $results = parent::get(
            $query,
            [
                ":em_email"          => $email
            ]
        );

        return count($results) > 0 ? true : false;
    }

    public static function getUserByEmail(string $em_email)
    {
        $query = "SELECT * FROM view_emanagers WHERE em_email = :em_email";

        $results = parent::get(
            $query,
            [
                ":em_email"          => $em_email
            ]
        );

        return count($results) > 0 ? $results[0] : null;
    }

    public static function createUser($emanager)
    {
        $query = "CALL insert_emanager(:em_name, :em_email, :em_phone, :em_password, :em_gender, :em_dob, :em_area, :em_subdistrict, :em_district, :em_division);";

        return parent::execute(
            $query,
            [
                ":em_name"           => $emanager->getUName(),
                ":em_email"          => $emanager->getUEmail(),
                ":em_phone"          => $emanager->getUPhone(),
                ":em_password"       => $emanager->getUPassword(),
                ":em_gender"         => $emanager->getUGender(),
                ":em_dob"            => $emanager->getUDob(),
                ":em_area"           => $emanager->getEmArea(),
                ":em_subdistrict"    => $emanager->getEmSubdistrict(),
                ":em_district"       => $emanager->getEmDistrict(),
                ":em_division"       => $emanager->getEmDivision(),
            ]
        );
    }

    public static function updateUser($emanager)
    {
        $query = "CALL update_emanager(:em_id, :em_name, :em_email, :em_phone, :em_gender, :em_dob, :em_work_subdistrict, :em_area, :em_subdistrict, :em_district, :em_division);";

        return parent::execute(
            $query,
            [
                ":em_id"                => $emanager->getEmId(),
                ":em_name"              => $emanager->getUName(),
                ":em_email"             => $emanager->getUEmail(),
                ":em_phone"             => $emanager->getUPhone(),
                ":em_gender"            => $emanager->getUGender(),
                ":em_dob"               => $emanager->getUDob(),
                ":em_work_subdistrict"  => $emanager->getEmWorkArea(),
                ":em_area"              => $emanager->getEmArea(),
                ":em_subdistrict"       => $emanager->getEmSubdistrict(),
                ":em_district"          => $emanager->getEmDistrict(),
                ":em_division"          => $emanager->getEmDivision(),
            ]
        );
    }

    public static function deleteUser(int $emanager_id)
    {
        $query = "CALL delete_emanager(:em_id);";

        return parent::execute(
            $query,
            [
                ":em_id"          => $emanager_id
            ]
        );
    }

    public static function isDuplicateAmbulancePhone($am_phone)
    {
        $query = "SELECT * FROM view_ambulances WHERE am_phone = :am_phone";

        $results = parent::get(
            $query,
            [
                ":am_phone"          => $am_phone
            ]
        );

        return count($results) > 0 ? true : false;
    }

    public static function isDuplicateHospitalEmail($h_email)
    {
        $query = "SELECT * FROM view_hospitals WHERE h_email = :h_email";

        $results = parent::get(
            $query,
            [
                ":h_email"          => $h_email
            ]
        );

        return count($results) > 0 ? true : false;
    }

    public static function createAmbulance($ambulance)
    {
        $query = "CALL insert_ambulance(:am_phone, :am_area, :am_subdistrict, :am_district, :am_division);";

        return parent::execute(
            $query,
            [
                ":am_phone"          => $ambulance->getAmPhone(),
                ":am_area"           => $ambulance->getAmArea(),
                ":am_subdistrict"    => $ambulance->getAmSubdistrict(),
                ":am_district"       => $ambulance->getAmDistrict(),
                ":am_division"       => $ambulance->getAmDivision(),
            ]
        );
    }

    public static function createHospital($hospital)
    {
        $query = "CALL insert_hospital(:h_name, :h_email, :h_phone, :h_area, :h_subdistrict, :h_district, :h_division);";

        return parent::execute(
            $query,
            [
                ":h_name"           => $hospital->getHName(),
                ":h_email"          => $hospital->getHEmail(),
                ":h_phone"          => $hospital->getHPhone(),
                ":h_area"           => $hospital->getHArea(),
                ":h_subdistrict"    => $hospital->getHSubdistrict(),
                ":h_district"       => $hospital->getHDistrict(),
                ":h_division"       => $hospital->getHDivision(),
            ]
        );
    }

    public static function getAllAmbulances($area = "", $phone = "")
    {
        if (empty($area) && !empty($phone)) {
            $query = "SELECT * FROM view_ambulances WHERE am_phone = :am_phone";

            return parent::get(
                $query,
                [
                    ":am_phone"     => $phone
                ]
            );
        } else if (!empty($area) && empty($phone)) {
            $query = "SELECT * FROM view_ambulances WHERE am_area LIKE :am_area";

            return parent::get(
                $query,
                [
                    ":am_area"      => "%$area%"
                ]
            );
        } else if (!empty($phone) && !empty($area)) {
            $query = "SELECT * FROM view_ambulances WHERE am_area LIKE :am_area AND am_phone = :am_phone";

            return parent::get(
                $query,
                [
                    ":am_area"      => "%$area%",
                    ":am_phone"     => $phone
                ]
            );
        } else {
            $query = "SELECT * FROM view_ambulances WHERE 1";

            return parent::get($query);
        }
    }

    public static function getAllHospitals($area = "", $email = "")
    {
        if (empty($area) && !empty($email)) {
            $query = "SELECT * FROM view_hospitals WHERE h_email = :h_email";

            return parent::get(
                $query,
                [
                    ":h_email"     => $email
                ]
            );
        } else if (!empty($area) && empty($email)) {
            $query = "SELECT * FROM view_hospitals WHERE h_area LIKE :h_area";

            return parent::get(
                $query,
                [
                    ":h_area"      => "%$area%"
                ]
            );
        } else if (!empty($email) && !empty($area)) {
            $query = "SELECT * FROM view_hospitals WHERE h_area LIKE :h_area AND h_email = :h_email";

            return parent::get(
                $query,
                [
                    ":h_area"      => "%$area%",
                    ":h_email"     => $email
                ]
            );
        } else {
            $query = "SELECT * FROM view_hospitals WHERE 1";

            return parent::get($query);
        }
    }

    public static function getAmbulanceById(int $id)
    {
        $query = "SELECT * FROM view_ambulances WHERE am_id = :am_id";

        $results = parent::get(
            $query,
            [
                ":am_id"          => $id
            ]
        );

        return count($results) > 0 ? $results[0] : null;
    }

    public static function getHospitalById(int $id)
    {
        $query = "SELECT * FROM view_hospitals WHERE h_id = :h_id";

        $results = parent::get(
            $query,
            [
                ":h_id"          => $id
            ]
        );

        return count($results) > 0 ? $results[0] : null;
    }

    public static function updateAmbulance($ambulance)
    {
        $query = "CALL update_ambulance(:am_id, :am_phone, :am_area, :am_subdistrict, :am_district, :am_division);";

        return parent::execute(
            $query,
            [
                ":am_id"                => $ambulance->getAmId(),
                ":am_phone"             => $ambulance->getAmPhone(),
                ":am_area"              => $ambulance->getAmArea(),
                ":am_subdistrict"       => $ambulance->getAmSubdistrict(),
                ":am_district"          => $ambulance->getAmDistrict(),
                ":am_division"          => $ambulance->getAmDivision(),
            ]
        );
    }

    public static function updateHospital($hospital)
    {
        $query = "CALL update_hospital(:h_id, :h_name, :h_email, :h_phone, :h_area, :h_subdistrict, :h_district, :h_division);";

        return parent::execute(
            $query,
            [
                ":h_id"                => $hospital->getHId(),
                ":h_name"              => $hospital->getHName(),
                ":h_email"             => $hospital->getHEmail(),
                ":h_phone"             => $hospital->getHPhone(),
                ":h_area"              => $hospital->getHArea(),
                ":h_subdistrict"       => $hospital->getHSubdistrict(),
                ":h_district"          => $hospital->getHDistrict(),
                ":h_division"          => $hospital->getHDivision(),
            ]
        );
    }

    public static function deleteAmbulance(int $id)
    {
        $query = "CALL delete_ambulance(:am_id);";

        return parent::execute(
            $query,
            [
                ":am_id"          => $id
            ]
        );
    }

    public static function deleteHospital(int $id)
    {
        $query = "CALL delete_hospital(:h_id);";

        return parent::execute(
            $query,
            [
                ":h_id"          => $id
            ]
        );
    }
}
