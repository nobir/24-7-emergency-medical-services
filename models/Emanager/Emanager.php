<?php

/**
 * Can't access directly by URL
 */

defined("_DIRECT_ACCESS") or exit("<h1>Your are not allowed</h1>");

require_once dirname(__FILE__, 3) . "/helper/functions.php";

require_once _ROOT_DIR . "models/User/User.php";

class Emanager extends User
{
    private int $em_id;
    private string $em_work_area;
    private string $em_area;
    private string $em_subdistrict;
    private string $em_district;
    private string $em_division;

    public function setEmId(int $em_id)
    {
        $this->em_id = $em_id;
    }

    public function getEmId(): int
    {
        return $this->em_id;
    }

    public function setEmWorkArea(string $em_work_area)
    {
        $this->em_work_area = $em_work_area;
    }

    public function getEmWorkArea(): string
    {
        return $this->em_work_area;
    }

    public function setEmArea(string $em_area)
    {
        $this->em_area = $em_area;
    }

    public function getEmArea(): string
    {
        return $this->em_area;
    }

    public function setEmSubdistrict(string $em_subdistrict)
    {
        $this->em_subdistrict = $em_subdistrict;
    }

    public function getEmSubdistrict(): string
    {
        return $this->em_subdistrict;
    }

    public function setEmDistrict(string $em_district)
    {
        $this->em_district = $em_district;
    }

    public function getEmDistrict(): string
    {
        return $this->em_district;
    }

    public function setEmDivision(string $em_division)
    {
        $this->em_division = $em_division;
    }

    public function getEmDivision(): string
    {
        return $this->em_division;
    }
}
