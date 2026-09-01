<?php

session_start();


/*
 * Set timezone
 */

date_default_timezone_set(
    "Asia/Kolkata"
);


$message = "";

$messageType = "";


/*
 * Check whether the form is submitted
 */

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $participantName =
        trim($_POST["participant_name"]);

    $email =
        trim($_POST["email"]);

    $eventName =
        trim($_POST["event_name"]);

    $eventDate =
        $_POST["event_date"];

    $eventTime =
        $_POST["event_time"];


    /*
     * Validate required fields
     */

    if (
        empty($participantName) ||
        empty($email) ||
        empty($eventName) ||
        empty($eventDate) ||
        empty($eventTime)
    ) {

        $message =
            "Please fill in all required fields.";

        $messageType =
            "error";

    }

    else {

        /*
         * Create DateTime object
         * for event scheduling
         */

        $eventDateTime =
            new DateTime(
                $eventDate . " " .
                $eventTime
            );


        /*
         * Get current date and time
         */

        $currentDateTime =
            new DateTime();


        /*
         * Check whether the event
         * is scheduled in the future
         */

        if (
            $eventDateTime <=
            $currentDateTime
        ) {

            $message =
                "Event date and time must be in the future.";

            $messageType =
                "error";

        }

        else {

            /*
             * Create event information
             */

            $eventRecord =
                "-----------------------------------" .
                PHP_EOL .

                "Participant Name: " .
                $participantName .
                PHP_EOL .

                "Email: " .
                $email .
                PHP_EOL .

                "Event Name: " .
                $eventName .
                PHP_EOL .

                "Event Date: " .
                $eventDateTime->format("d-m-Y") .
                PHP_EOL .

                "Event Time: " .
                $eventDateTime->format("h:i A") .
                PHP_EOL .

                "Registration Date: " .
                date("d-m-Y h:i:s A") .
                PHP_EOL .

                "-----------------------------------" .
                PHP_EOL;


            /*
             * Store event information
             * in a text file
             */

            $fileName =
                "event_records.txt";


            if (
                file_put_contents(
                    $fileName,
                    $eventRecord,
                    FILE_APPEND
                ) !== false
            ) {

                /*
                 * Increase registration count
                 * using session variable
                 */

                $_SESSION["registration_count"]++;


                /*
                 * Store participant details
                 * in session
                 */

                $_SESSION["participant_name"] =
                    $participantName;

                $_SESSION["event_name"] =
                    $eventName;


                $message =
                    "Event registration completed successfully.";

                $messageType =
                    "success";

            }

            else {

                $message =
                    "Unable to store event information.";

                $messageType =
                    "error";

            }

        }

    }

}

?>

<!DOCTYPE html>
<html>

<head>

    <title>Event Registration Result</title>

    <link rel="stylesheet"
          href="style.css">

</head>

<body>

<div class="container">

    <h1>Event Registration Result</h1>


<?php

/*
 * Display success or error message
 */

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
 * Display event schedule
 */

if ($messageType == "success") {

?>

<div class="schedule-box">

    <h2>Event Schedule</h2>


    <p>

        <strong>
            Participant Name:
        </strong>

        <?php
        echo htmlspecialchars(
            $_SESSION["participant_name"]
        );
        ?>

    </p>


    <p>

        <strong>
            Event Name:
        </strong>

        <?php
        echo htmlspecialchars(
            $_SESSION["event_name"]
        );
        ?>

    </p>


    <p>

        <strong>
            Event Date:
        </strong>

        <?php
        echo $eventDateTime->format(
            "d-m-Y"
        );
        ?>

    </p>


    <p>

        <strong>
            Event Time:
        </strong>

        <?php
        echo $eventDateTime->format(
            "h:i A"
        );
        ?>

    </p>


    <p>

        <strong>
            Total Registrations in Session:
        </strong>

        <?php
        echo $_SESSION[
            "registration_count"
        ];
        ?>

    </p>

</div>

<?php

}

?>

<br>

<a href="index.php"
   class="back">

    Register Another Event

</a>

</div>

</body>

</html>