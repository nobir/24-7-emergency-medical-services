<?php

/**
 * Can't access directly by URL
 */

defined("_DIRECT_ACCESS") or exit("<h1>Your are not allowed</h1>");

require_once dirname(__FILE__, 3) . "/helper/functions.php";

require_once _ROOT_DIR . "models/User/User.php";

class Hospital
{
    private int $h_id;
    private string $h_name;
    private string $h_email;
    private string $h_phone;
    private string $h_area;
    private string $h_subdistrict;
    private string $h_district;
    private string $h_division;

    public function setHId(int $h_id)
    {
        $this->h_id = $h_id;
    }

    public function getHId(): int
    {
        return $this->h_id;
    }

    public function setHName(string $h_name): void
    {
        $this->h_name = $h_name;
    }

    public function getHName(): string
    {
        return $this->h_name;
    }

    public function setHEmail(string $h_email): void
    {
        $this->h_email = $h_email;
    }

    public function getHEmail(): string
    {
        return $this->h_email;
    }


    public function setHPhone(string $h_phone)
    {
        $this->h_phone = $h_phone;
    }

    public function getHPhone(): string
    {
        return $this->h_phone;
    }

    public function setHArea(string $h_area)
    {
        $this->h_area = $h_area;
    }

    public function getHArea(): string
    {
        return $this->h_area;
    }

    public function setHSubdistrict(string $h_subdistrict)
    {
        $this->h_subdistrict = $h_subdistrict;
    }

    public function getHSubdistrict(): string
    {
        return $this->h_subdistrict;
    }

    public function setHDistrict(string $h_district)
    {
        $this->h_district = $h_district;
    }

    public function getHDistrict(): string
    {
        return $this->h_district;
    }

    public function setHDivision(string $h_division)
    {
        $this->h_division = $h_division;
    }

    public function getHDivision(): string
    {
        return $this->h_division;
    }
}
