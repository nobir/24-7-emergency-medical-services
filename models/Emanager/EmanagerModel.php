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
}
