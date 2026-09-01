<?php

session_start();


/*
 * Initialize session array
 */

if (!isset($_SESSION["visited_pages"])) {

    $_SESSION["visited_pages"] = [];

}


/*
 * Reset browsing session
 */

if (isset($_POST["reset"])) {

    session_unset();

    session_destroy();


    header(
        "Location: index.php"
    );

    exit;

}


/*
 * Get visited pages
 */

$visitedPages =
    $_SESSION["visited_pages"];


/*
 * Count visited pages
 */

$pageCount =
    count(
        $visitedPages
    );

?>

<!DOCTYPE html>
<html>

<head>

    <title>Session Report</title>

    <link rel="stylesheet"
          href="style.css">

</head>

<body>

<div class="container">

    <h1>Visitor Session Report</h1>


<div class="count-box">

    <h2>Total Pages Visited</h2>

    <p class="count">

        <?php
        echo $pageCount;
        ?>

    </p>

</div>


<div class="report-box">

    <h2>Pages Visited During This Session</h2>

    <ul>

<?php

foreach (
    $visitedPages
    as $page
) {

?>

        <li>

            <?php

            echo htmlspecialchars(
                $page
            );

            ?>

        </li>

<?php

}

?>

    </ul>

</div>


<a href="index.php"
   class="back">

    Continue Browsing

</a>

</div>

</body>

</html>