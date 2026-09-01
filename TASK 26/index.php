<?php

session_start();


/*
 * Initialize visited pages
 */

if (!isset($_SESSION["visited_pages"])) {

    $_SESSION["visited_pages"] = [];

}


/*
 * Add Home Page to session
 */

if (
    !in_array(
        "Home Page",
        $_SESSION["visited_pages"]
    )
) {

    $_SESSION["visited_pages"][] =
        "Home Page";

}


/*
 * Count visited pages
 */

$pageCount =
    count(
        $_SESSION["visited_pages"]
    );

?>

<!DOCTYPE html>
<html>

<head>

    <title>Visitor Session Tracking System</title>

    <link rel="stylesheet" href="style.css">

</head>

<body>

<div class="container">

    <h1>Visitor Session Tracking System</h1>

    <p>
        Track the pages visited during your browsing session.
    </p>


    <div class="count-box">

        <h2>Pages Visited</h2>

        <p class="count">

            <?php
            echo $pageCount;
            ?>

        </p>

    </div>


    <h2>Navigate Pages</h2>

    <div class="links">

        <a href="about.php">
            About Page
        </a>

        <a href="services.php">
            Services Page
        </a>

        <a href="contact.php">
            Contact Page
        </a>

    </div>


    <form action="process.php"
          method="post">

        <input type="submit"
               name="view"
               value="View Session Report">

        <input type="submit"
               name="reset"
               value="Reset Session">

    </form>

</div>

</body>

</html>