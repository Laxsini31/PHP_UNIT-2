<?php

session_start();


/*
 * Remove all session variables
 */

session_unset();


/*
 * Destroy the current session
 */

session_destroy();


/*
 * Delete authentication cookie
 */

setcookie(
    "remember_user",
    "",
    time() - 3600,
    "/"
);


/*
 * Redirect user to login page
 */

header("Location: index.php");

exit();

?>