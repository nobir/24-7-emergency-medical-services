<?php

/**
 * Can't access directly by URL
 */

defined("_DIRECT_ACCESS") or exit("<h1>Your are not allowed</h1>");

return [
    "APP_NAME"      => basename(dirname(__FILE__, 2)),
    "EXPIRED"       => 60 * 60 * 24 * 7,    // 60 * 60 * 24 * 7 = 7 days
    "UPLOAD_DIR"    => "assets/uploads/",
    "DB_HOST"       => "localhost",
    "DB_NAME"       => "ems",
    "DB_USERNAME"   => "root",
    "DB_PASSWORD"   => "",
    "THEME_COLOR"   => "success",
    "DEV_MODE"      => true,
    // "THEME_COLOR"   => ["success", "danger", "warning", "info", "dark"][rand(0,4)],
];
