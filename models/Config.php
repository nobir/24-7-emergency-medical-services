<?php

/**
 * Can't access directly by URL
 */

defined("_DIRECT_ACCESS") or exit("<h1>Your are not allowed</h1>");

// Project nested level
$level = 0;

$app_name = basename(dirname(__FILE__, 2));

for ($i = 0; $i < $level; $i++) {
    $app_name = basename(dirname(__FILE__, $i + 2)) . "/" . $app_name;
}

return [
    "APP_NAME"      => $app_name,
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
