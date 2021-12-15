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

        return parent::execute(
            $query,
            [
                ":a_id"          => $admin_id
            ]
        );
    }

    public static function getAllUsers($name = "", $email = "")
    {
        if (empty($name) && !empty($email)) {
            $query = "SELECT * FROM ems_users WHERE u_email = :u_email";

            return parent::get(
                $query,
                [
                    ":u_email"     => $email
                ]
            );
        } else if (!empty($name) && empty($email)) {
            $query = "SELECT * FROM ems_users WHERE u_name LIKE :u_name";

            return parent::get(
                $query,
                [
                    ":u_name"      => "%$name%"
                ]
            );
        } else if (!empty($email) && !empty($name)) {
            $query = "SELECT * FROM ems_users WHERE u_name LIKE :u_name AND u_email = :u_email";

            return parent::get(
                $query,
                [
                    ":u_name"      => "%$name%",
                    ":u_email"     => $email
                ]
            );
        } else {
            $query = "SELECT * FROM ems_users WHERE 1";

            return parent::get($query);
        }
    }

    public static function getAllUnverifiedDoctors()
    {
        $query = "SELECT * FROM view_doctors WHERE d_verify = 0";

        return parent::get($query);
    }

    public static function verifyDoctor(int $d_id)
    {
        $query = "UPDATE ems_doctors SET d_verify = 1 WHERE d_id = :d_id;";

        return parent::execute(
            $query,
            [
                ":d_id"         => $d_id
            ]
        );
    }
}
