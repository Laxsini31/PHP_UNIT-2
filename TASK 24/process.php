<?php

session_start();


/*
 * Create logs directory
 */

$logDirectory = "logs";


if (!is_dir($logDirectory)) {

    mkdir(
        $logDirectory,
        0777,
        true
    );

}


/*
 * File paths
 */

$loginLog =
    $logDirectory .
    "/login_history.txt";


$fileAccessLog =
    $logDirectory .
    "/file_access_log.txt";


/*
 * Logout operation
 */

if (
    isset($_GET["action"])
    &&
    $_GET["action"] == "logout"
) {

    if (isset($_SESSION["user_name"])) {

        $userName =
            $_SESSION["user_name"];


        $logoutEntry =
            "User: " .
            $userName .
            " | Activity: Logout" .
            " | Time: " .
            date("d-m-Y h:i:s A") .
            PHP_EOL;


        file_put_contents(
            $loginLog,
            $logoutEntry,
            FILE_APPEND
        );

    }


    session_destroy();


    header(
        "Location: index.php"
    );

    exit;

}


/*
 * User login
 */

if (isset($_POST["login"])) {

    $userName =
        trim(
            $_POST["user_name"]
        );


    if (empty($userName)) {

        $message =
            "Please enter your user name.";

    }

    else {

        /*
         * Store user in session
         */

        $_SESSION["user_name"] =
            $userName;


        /*
         * Store user in cookie
         */

        setcookie(
            "user_name",
            $userName,
            time() + 86400 * 7,
            "/"
        );


        /*
         * Store login activity
         */

        $loginEntry =
            "User: " .
            $userName .
            " | Activity: Login" .
            " | Time: " .
            date("d-m-Y h:i:s A") .
            PHP_EOL;


        file_put_contents(
            $loginLog,
            $loginEntry,
            FILE_APPEND
        );


        header(
            "Location: index.php"
        );

        exit;

    }

}


/*
 * Check user session
 */

if (!isset($_SESSION["user_name"])) {

    die(
        "Unauthorized access. Please login first."
    );

}


$userName =
    $_SESSION["user_name"];


/*
 * Access selected file
 */

if (isset($_POST["access_file"])) {

    $fileName =
        $_POST["file_name"];


    $allowedFiles = [

        "student_report.txt",

        "attendance_report.txt",

        "marks_report.txt"

    ];


    if (
        !in_array(
            $fileName,
            $allowedFiles
        )
    ) {

        $message =
            "Invalid file selected.";

    }

    else {

        /*
         * Record file access
         */

        $accessEntry =
            "User: " .
            $userName .
            " | File: " .
            $fileName .
            " | Access Time: " .
            date("d-m-Y h:i:s A") .
            PHP_EOL;


        file_put_contents(
            $fileAccessLog,
            $accessEntry,
            FILE_APPEND
        );


        $message =
            "File access recorded successfully.";

    }

}


/*
 * Generate activity report
 */

$loginHistory = [];

$fileHistory = [];


if (isset($_POST["view_report"])) {

    if (file_exists($loginLog)) {

        $loginHistory =
            file(
                $loginLog,
                FILE_IGNORE_NEW_LINES
            );

    }


    if (file_exists($fileAccessLog)) {

        $fileHistory =
            file(
                $fileAccessLog,
                FILE_IGNORE_NEW_LINES
            );

    }

}

?>

<!DOCTYPE html>
<html>

<head>

    <title>User Activity Result</title>

    <link rel="stylesheet"
          href="style.css">

</head>

<body>

<div class="container">

    <h1>User Activity and File Access Result</h1>


<?php

if (isset($message)) {

?>

<div class="success-box">

    <h2>Success!</h2>

    <p>

        <?php

        echo htmlspecialchars(
            $message
        );

        ?>

    </p>

</div>

<?php

}

?>


<?php

if (isset($_POST["view_report"])) {

?>

<div class="report-box">

    <h2>Login History</h2>


<?php

if (count($loginHistory) > 0) {

?>

<ul>

<?php

foreach (
    $loginHistory
    as $entry
) {

?>

    <li>

        <?php

        echo htmlspecialchars(
            $entry
        );

        ?>

    </li>

<?php

}

?>

</ul>

<?php

}

else {

?>

<p>
    No login history available.
</p>

<?php

}

?>


<h2>File Access History</h2>


<?php

if (count($fileHistory) > 0) {

?>

<ul>

<?php

foreach (
    $fileHistory
    as $entry
) {

?>

    <li>

        <?php

        echo htmlspecialchars(
            $entry
        );

        ?>

    </li>

<?php

}

?>

</ul>

<?php

}

else {

?>

<p>
    No file access history available.
</p>

<?php

}

?>

</div>

<?php

}

?>


<a href="index.php"
   class="back">

    Back to Home

</a>

</div>

</body>

</html>