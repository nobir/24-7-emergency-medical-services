<?php

/**
 * Can't access directly by URL
 */

defined("_DIRECT_ACCESS") or exit("<h1>Your are not allowed</h1>");

require_once dirname(__FILE__, 3) . "/helper/functions.php";

class User
{
    private int $u_id;
    private string $u_name;
    private string $u_email;
    private string $u_phone;
    private string $u_password;
    private string $u_gender;
    private string $u_dob;
    private string $u_type;
    private string $u_pp_path;

    public function setUId(int $u_id): void
    {
        $this->u_id = $u_id;
    }

    public function getUId(): int
    {
        return $this->u_id;
    }

    public function setUName(string $u_name): void
    {
        $this->u_name = $u_name;
    }

    public function getUName(): string
    {
        return $this->u_name;
    }

    public function setUEmail(string $u_email): void
    {
        $this->u_email = $u_email;
    }

    public function getUEmail(): string
    {
        return $this->u_email;
    }

    public function setUPhone(string $u_phone): void
    {
        $this->u_phone = $u_phone;
    }

    public function getUPhone(): string
    {
        return $this->u_phone;
    }

    public function setUPassword(string $u_password): void
    {
        $this->u_password = $u_password;
    }

    public function getUPassword(): string
    {
        return $this->u_password;
    }

    public function setUGender(string $u_gender): void
    {
        $this->u_gender = $u_gender;
    }

    public function getUGender(): string
    {
        return $this->u_gender;
    }

    public function setUDob(string $u_dob): void
    {
        $this->u_dob = $u_dob;
    }

    public function getUDob(): string
    {
        return $this->u_dob;
    }

    public function setUType(string $u_type): void
    {
        $this->u_type = $u_type;
    }

    public function getUType(): string
    {
        return $this->u_type;
    }

    public function setUPpPath(string $u_pp_path): void
    {
        $this->u_pp_path = $u_pp_path;
    }

    public function getUPpPath(): string
    {
        return $this->u_pp_path;
    }
}
