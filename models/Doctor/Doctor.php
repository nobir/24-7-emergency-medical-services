<?php

/**
 * Can't access directly by URL
 */

defined("_DIRECT_ACCESS") or exit("<h1>Your are not allowed</h1>");

require_once dirname(__FILE__, 3) . "/helper/functions.php";

require_once _ROOT_DIR . "models/User/User.php";

class Doctor extends User
{
    private int $d_id;
    private string $d_degree;
    private string $d_specialization;
    private string $d_schedule;
    private int $d_verify;
    private string $d_area;
    private string $d_subdistrict;
    private string $d_district;
    private string $d_division;

    public function setDId(int $d_id)
    {
        $this->d_id = $d_id;
    }

    public function getDId(): int
    {
        return $this->d_id;
    }

    public function setDDegree(string $d_degree)
    {
        $this->d_degree = $d_degree;
    }

    public function getDDegree(): string
    {
        return $this->d_degree;
    }

    public function setDSpecialization(string $d_specialization)
    {
        $this->d_specialization = $d_specialization;
    }

    public function getDSpecialization(): string
    {
        return $this->d_specialization;
    }

    public function setDSchedule(string $d_schedule)
    {
        $this->d_schedule = $d_schedule;
    }

    public function getDSchedule(): string
    {
        return $this->d_schedule;
    }

    public function setDVerify(int $d_verify)
    {
        $this->d_verify = $d_verify;
    }

    public function getDVerify(): int
    {
        return $this->d_verify;
    }

    public function setDArea(string $d_area)
    {
        $this->d_area = $d_area;
    }

    public function getDArea(): string
    {
        return $this->d_area;
    }

    public function setDSubdistrict(string $d_subdistrict)
    {
        $this->d_subdistrict = $d_subdistrict;
    }

    public function getDSubdistrict(): string
    {
        return $this->d_subdistrict;
    }

    public function setDDistrict(string $d_district)
    {
        $this->d_district = $d_district;
    }

    public function getDDistrict(): string
    {
        return $this->d_district;
    }

    public function setDDivision(string $d_division)
    {
        $this->d_division = $d_division;
    }

    public function getDDivision(): string
    {
        return $this->d_division;
    }
}
