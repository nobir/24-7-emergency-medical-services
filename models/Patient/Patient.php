<?php

/**
 * Can't access directly by URL
 */

defined("_DIRECT_ACCESS") or exit("<h1>Your are not allowed</h1>");

require_once dirname(__FILE__, 3) . "/helper/functions.php";

require_once _ROOT_DIR . "models/User/User.php";

class Patient extends User
{
    private int $p_id;
    private string $p_area;
    private string $p_subdistrict;
    private string $p_district;
    private string $p_division;

    public function setPId(int $p_id)
    {
        $this->p_id = $p_id;
    }

    public function getPId(): int
    {
        return $this->p_id;
    }

    public function setPArea(string $p_area)
    {
        $this->p_area = $p_area;
    }

    public function getPArea(): string
    {
        return $this->p_area;
    }

    public function setPSubdistrict(string $p_subdistrict)
    {
        $this->p_subdistrict = $p_subdistrict;
    }

    public function getPSubdistrict(): string
    {
        return $this->p_subdistrict;
    }

    public function setPDistrict(string $p_district)
    {
        $this->p_district = $p_district;
    }

    public function getPDistrict(): string
    {
        return $this->p_district;
    }

    public function setPDivision(string $p_division)
    {
        $this->p_division = $p_division;
    }

    public function getPDivision(): string
    {
        return $this->p_division;
    }
}
