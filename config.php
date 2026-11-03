<?php
// config.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
define("DB_HOST", "localhost");
define("DB_PORT", 8889);
define("DB_USER", "root");
define("DB_PASS", "root");
define("DB_NAME", "fitlife_db");
