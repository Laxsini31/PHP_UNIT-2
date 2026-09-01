<?php

session_start();


if (!isset($_SESSION["visited_pages"])) {

    $_SESSION["visited_pages"] = [];

}


if (
    !in_array(
        "Contact Page",
        $_SESSION["visited_pages"]
    )
) {

    $_SESSION["visited_pages"][] =
        "Contact Page";

}


$pageCount =
    count(
        $_SESSION["visited_pages"]
    );

?>

<!DOCTYPE html>
<html>

<head>

    <title>Contact Page</title>

    <link rel="stylesheet" href="style.css">

</head>

<body>

<div class="container">

    <h1>Contact Page</h1>

    <p>
        This page is recorded in your browsing session.
    </p>


    <div class="count-box">

        <h2>Total Pages Visited</h2>

        <p class="count">

            <?php
            echo $pageCount;
            ?>

        </p>

    </div>


    <a href="index.php"
       class="back">

        Back to Home

    </a>

</div>

</body>

</html>