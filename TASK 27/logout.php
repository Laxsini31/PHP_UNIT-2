<?php

session_start();


/*
 * Remove examination session
 */

session_unset();


session_destroy();


/*
 * Remove user cookie
 */

setcookie(
    "exam_user",
    "",
    time() - 3600,
    "/"
);


/*
 * Redirect using HTTP header
 */

header(
    "Location: index.php"
);

exit;

?>