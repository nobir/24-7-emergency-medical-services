<?php

/**
 * Can't access directly by URL
 */

defined("_DIRECT_ACCESS") or exit("<h1>Your are not allowed</h1>");

require_once dirname(__FILE__, 3) . "/helper/functions.php";

require_once _ROOT_DIR . "models/User/User.php";

class Ambulance
{
    private int $am_id;
    private string $am_phone;
    private string $am_area;
    private string $am_subdistrict;
    private string $am_district;
    private string $am_division;

    public function setAmId(int $am_id)
    {
        $this->am_id = $am_id;
    }

    public function getAmId(): int
    {
        return $this->am_id;
    }

    public function setAmPhone(string $am_phone)
    {
        $this->am_phone = $am_phone;
    }

    public function getAmPhone(): string
    {
        return $this->am_phone;
    }

    public function setAmArea(string $am_area)
    {
        $this->am_area = $am_area;
    }

    public function getAmArea(): string
    {
        return $this->am_area;
    }

    public function setAmSubdistrict(string $am_subdistrict)
    {
        $this->am_subdistrict = $am_subdistrict;
    }

    public function getAmSubdistrict(): string
    {
        return $this->am_subdistrict;
    }

    public function setAmDistrict(string $am_district)
    {
        $this->am_district = $am_district;
    }

    public function getAmDistrict(): string
    {
        return $this->am_district;
    }

    public function setAmDivision(string $am_division)
    {
        $this->am_division = $am_division;
    }

    public function getAmDivision(): string
    {
        return $this->am_division;
    }
}
