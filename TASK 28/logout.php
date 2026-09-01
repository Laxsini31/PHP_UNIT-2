<?php

session_start();


/*
 * Remove session data
 */

session_unset();


/*
 * Destroy secure session
 */

session_destroy();


/*
 * Redirect to login page
 */

header(
    "Location: index.php"
);

exit;

?>