<?php

session_start();


/*
 * Remove all session values
 */

session_unset();


/*
 * Destroy the session
 */

session_destroy();


/*
 * Remove user cookie
 */

setcookie(
    "shopping_user",
    "",
    time() - 3600,
    "/"
);


/*
 * Redirect to login page
 */

header(
    "Location: index.php"
);

exit();

?>