<?php

define("DB_SERVER", "localhost");
define("DB_USER", "***");
define("DB_PASS", "***");
define("DB_NAME", "***");


define("TBL_USERS", "users");
define("TBL_ACTIVE_USERS", "active_users");
define("TBL_ACTIVE_GUESTS", "active_guests");
define("TBL_BANNED_USERS", "banned_users");


define("ADMIN_NAME", "Administratorius");
define("MANAGER_NAME", "Valdytojas");
define("USER_NAME", "Vartotojas");
define("GUEST_NAME", "Svečias");
define("ADMIN_LEVEL", 9);
define("MANAGER_LEVEL", 5);
define("USER_LEVEL", 1);
define("GUEST_LEVEL", 0);


define("TRACK_VISITORS", true);


define("USER_TIMEOUT", 10);
define("GUEST_TIMEOUT", 5);


define("COOKIE_EXPIRE", 60 * 60 * 24 * 100);  
define("COOKIE_PATH", "/"); 


define("EMAIL_FROM_NAME", "Tikra Dovana");
define("EMAIL_FROM_ADDR", "tikradovana@info.lt");
define("EMAIL_WELCOME", false);


define("ALL_LOWERCASE", false);
?>
