<?php

/**
 * Can't access directly by URL
 */

defined("_DIRECT_ACCESS") or exit("<h1>Your are not allowed</h1>");
// define("_DIRECT_ACCESS", true);

require_once dirname(__FILE__, 2) . "/helper/functions.php";

require_once _ROOT_DIR . "models/Database.php";

abstract class Model
{
    protected static function execute($query, $bindparams = [])
    {
        $conn = Database::getConnection();

        $affected_rows = 0;

        if ($conn) {
            try {
                $stmt = $conn->prepare($query);
                $stmt->execute($bindparams);

                $affected_rows = $stmt->rowCount();
            } catch (PDOException $e) {

                if (_CONFIG['DEV_MODE'] === true) {
                    _var_dump($e->getMessage());
                    exit();
                }

                $affected_rows = 0;
            }
        }

        $conn = null;

        return $affected_rows;
    }

    protected static function get($query, $bindparams = [])
    {
        $conn = Database::getConnection();

        $results = [];

        if ($conn) {
            try {
                $stmt = $conn->prepare($query);
                $stmt->execute($bindparams);

                $results = $stmt->fetchAll();
            } catch (PDOException $e) {

                if (_CONFIG['DEV_MODE'] === true) {
                    _var_dump($e->getMessage());
                    exit();
                }

                $results = [];
            }
        }

        $conn = null;

        return $results;
    }

    public static function changeProfilePicture(string $picture_url, int $u_id)
    {
        $query = "UPDATE ems_users SET u_pp_path = :u_pp_path WHERE u_id = :u_id";

        return self::execute(
            $query,
            [
                ":u_pp_path"        => $picture_url,
                ":u_id"             => $u_id
            ]
        );
    }

    public static function changePassword(string $passowrd, int $u_id)
    {
        $query = "UPDATE ems_users SET u_password = :u_password WHERE u_id = :u_id";

        return self::execute(
            $query,
            [
                ":u_password"       => $passowrd,
                ":u_id"             => $u_id
            ]
        );
    }

    public abstract static function authUser(string $email, string $password);

    public abstract static function isDuplicateEmail(string $email);

    public abstract static function getUserByEmail(string $user_email);

    public abstract static function createUser($user);

    public abstract static function updateUser($user);

    public abstract static function deleteUser(int $user_id);
}

// _print_r(Model::get("SELECT * FROM user WHERE User = 'nobir'"));