<?php

/**
 * Can't access directly by URL
 */

defined("_DIRECT_ACCESS") or exit("<h1>Your are not allowed</h1>");

require_once dirname(__FILE__, 3) . "/helper/functions.php";

require_once _ROOT_DIR . "models/Model.php";
require_once _ROOT_DIR . "models/Admin/Admin.php";

class AdminModel extends Model
{
    public static function authUser(string $a_email, string $a_password)
    {
        $query = "SELECT * FROM view_admins WHERE a_email = :a_email";

        $results = parent::get(
            $query,
            [
                ":a_email"          => $a_email
            ]
        );

        return count($results) > 0 && password_verify($a_password, $results[0]['a_password']) ? $results[0] : null;
    }

    public static function isDuplicateEmail(string $email)
    {
        $query = "SELECT * FROM view_admins WHERE a_email = :a_email";

        $results = parent::get(
            $query,
            [
                ":a_email"      => $email
            ]
        );

        return count($results) > 0 ? true : false;
    }

    public static function getUserByEmail(string $a_email)
    {
        $query = "SELECT * FROM view_admins WHERE a_email = :a_email";

        $results = parent::get(
            $query,
            [
                ":a_email"          => $a_email
            ]
        );

        return count($results) > 0 ? $results[0] : null;
    }

    public static function createUser($admin)
    {
        $query = "CALL insert_admin(:a_name, :a_email, :a_phone, :a_password, :a_gender, :a_dob);";

        return parent::execute(
            $query,
            [
                ":a_name"       => $admin->getUName(),
                ":a_email"      => $admin->getUEmail(),
                ":a_phone"      => $admin->getUPhone(),
                ":a_password"   => $admin->getUPassword(),
                ":a_gender"     => $admin->getUGender(),
                ":a_dob"        => $admin->getUDob()
            ]
        );
    }

    public static function updateUser($admin)
    {
        $query = "CALL update_admin(:a_id, :a_name, :a_email, :a_phone, :a_gender, :a_dob);";

        return parent::execute(
            $query,
            [
                ":a_id"         => $admin->getAId(),
                ":a_name"       => $admin->getUName(),
                ":a_email"      => $admin->getUEmail(),
                ":a_phone"      => $admin->getUPhone(),
                ":a_gender"     => $admin->getUGender(),
                ":a_dob"        => $admin->getUDob()
            ]
        );
    }

    public static function deleteUser(int $admin_id)
    {
        $query = "CALL delete_admin(:a_id);";

        $results = parent::get(
            $query,
            [
                ":a_id"          => $admin_id
            ]
        );

        return count($results) > 0 ? $results[0] : null;
    }
}
