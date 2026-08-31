<?php

$message = "";
$messageType = "";


/*
 * Set Indian timezone
 */

date_default_timezone_set(
    "Asia/Kolkata"
);


/*
 * Process form data
 */

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $projectName =
        trim($_POST["project_name"]);

    $activity =
        trim($_POST["activity"]);

    $memberName =
        trim($_POST["member_name"]);


    /*
     * Validate required fields
     */

    if (
        empty($projectName) ||
        empty($activity) ||
        empty($memberName)
    ) {

        $message =
            "Please fill in all required fields.";

        $messageType = "error";

    }

    else {

        /*
         * Get current date
         * Used to create a daily file name
         */

        $currentDate =
            date("Y-m-d");


        /*
         * Get current date and time
         */

        $currentDateTime =
            date("d-m-Y h:i:s A");


        /*
         * Automatically generate
         * the daily log file name
         */

        $fileName =
            "project_log_" .
            $currentDate .
            ".txt";


        /*
         * Create log information
         */

        $logRecord =
            "-----------------------------------" .
            PHP_EOL .

            "Project Name: " .
            $projectName .
            PHP_EOL .

            "Activity: " .
            $activity .
            PHP_EOL .

            "Team Member: " .
            $memberName .
            PHP_EOL .

            "Date and Time: " .
            $currentDateTime .
            PHP_EOL .

            "-----------------------------------" .
            PHP_EOL;


        /*
         * Store the project log
         * in the daily log file
         */

        if (
            file_put_contents(
                $fileName,
                $logRecord,
                FILE_APPEND
            ) !== false
        ) {

            $message =
                "Daily project log created and stored successfully.";

            $messageType =
                "success";

        }

        else {

            $message =
                "Unable to create the project log file.";

            $messageType =
                "error";

        }

    }

}

?>

<!DOCTYPE html>
<html>

<head>

    <title>Project Log Result</title>

    <link rel="stylesheet"
          href="style.css">

</head>

<body>

<div class="container">

    <h1>Daily Project Log Result</h1>


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
 * Display generated log details
 */

if (
    $messageType == "success"
) {

?>

<div class="log-box">

    <h2>
        Generated Log Details
    </h2>


    <p>

        <strong>
            Project Name:
        </strong>

        <?php
        echo htmlspecialchars(
            $projectName
        );
        ?>

    </p>


    <p>

        <strong>
            Activity:
        </strong>

        <?php
        echo htmlspecialchars(
            $activity
        );
        ?>

    </p>


    <p>

        <strong>
            Team Member:
        </strong>

        <?php
        echo htmlspecialchars(
            $memberName
        );
        ?>

    </p>


    <p>

        <strong>
            Date and Time:
        </strong>

        <?php
        echo htmlspecialchars(
            $currentDateTime
        );
        ?>

    </p>


    <p>

        <strong>
            Generated File:
        </strong>

        <?php
        echo htmlspecialchars(
            $fileName
        );
        ?>

    </p>

</div>

<?php

}

?>

<br>

<a href="index.html"
   class="back">

    Add Another Project Log

</a>

</div>

</body>

</html>