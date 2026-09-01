<?php

/*
 * Set timezone
 */

date_default_timezone_set(
    "Asia/Kolkata"
);


$message = "";

$messageType = "";

$reportName = "";

$currentDate = "";

$currentTime = "";


/*
 * Check whether the form is submitted
 */

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $reportName =
        trim($_POST["report_name"]);

    $dateFormat =
        $_POST["date_format"];

    $timeFormat =
        $_POST["time_format"];


    /*
     * Validate report name
     */

    if (empty($reportName)) {

        $message =
            "Please enter the report name.";

        $messageType =
            "error";

    }

    else {

        /*
         * Generate date using
         * selected format
         */

        $currentDate =
            date($dateFormat);


        /*
         * Generate time using
         * selected format
         */

        $currentTime =
            date($timeFormat);


        /*
         * Generate additional
         * date and time formats
         */

        $standardDate =
            date("Y-m-d");

        $fullDate =
            date("l, d F Y");

        $shortDate =
            date("d/m/y");

        $twelveHourTime =
            date("h:i:s A");

        $twentyFourHourTime =
            date("H:i:s");


        $message =
            "Date and time report generated successfully.";

        $messageType =
            "success";

    }

}

?>

<!DOCTYPE html>
<html>

<head>

    <title>Date and Time Report</title>

    <link rel="stylesheet"
          href="style.css">

</head>

<body>

<div class="container">

    <h1>Date and Time Report</h1>


<?php

if (!empty($message)) {

?>

<div class="<?php

echo $messageType == "success"
    ? "success-box"
    : "error-box";

?>">

    <h2 class="<?php
    echo $messageType;
    ?>">

        <?php

        echo $messageType == "success"
            ? "Success!"
            : "Error!";

        ?>

    </h2>

    <p>

        <?php
        echo htmlspecialchars($message);
        ?>

    </p>

</div>

<?php

}


/*
 * Display customized report
 */

if ($messageType == "success") {

?>

<div class="report-box">

    <h2>
        <?php
        echo htmlspecialchars($reportName);
        ?>
    </h2>


    <p>

        <strong>
            Selected Date Format:
        </strong>

        <?php
        echo htmlspecialchars($currentDate);
        ?>

    </p>


    <p>

        <strong>
            Selected Time Format:
        </strong>

        <?php
        echo htmlspecialchars($currentTime);
        ?>

    </p>


    <hr>


    <h2>
        Current Date in Different Formats
    </h2>


    <p>

        <strong>
            Standard Format:
        </strong>

        <?php
        echo $standardDate;
        ?>

    </p>


    <p>

        <strong>
            Short Format:
        </strong>

        <?php
        echo $shortDate;
        ?>

    </p>


    <p>

        <strong>
            Full Format:
        </strong>

        <?php
        echo $fullDate;
        ?>

    </p>


    <h2>
        Current Time in Different Formats
    </h2>


    <p>

        <strong>
            12 Hour Format:
        </strong>

        <?php
        echo $twelveHourTime;
        ?>

    </p>


    <p>

        <strong>
            24 Hour Format:
        </strong>

        <?php
        echo $twentyFourHourTime;
        ?>

    </p>

</div>

<?php

}

?>

<br>

<a href="index.html"
   class="back">

    Generate Another Report

</a>

</div>

</body>

</html>