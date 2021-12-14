<?php

/**
 * Can't access directly by URL
 */

defined("_DIRECT_ACCESS") or exit("<h1>Your are not allowed</h1>");

require_once dirname(__FILE__, 3) . "/helper/functions.php";

require_once _ROOT_DIR . "models/User/User.php";

class Admin extends User
{
    private int $a_id;

    public function setAId(int $a_id)
    {
        $this->a_id = $a_id;
    }

    public function getAId(): int
    {
        return $this->a_id;
    }
}
