<?php

session_start();

$fileName = "activities.txt";

$message = "";
$messageType = "";


/*
 * ADD STUDENT ACTIVITY
 */

if (
    $_SERVER["REQUEST_METHOD"] == "POST" &&
    $_POST["action"] == "add"
) {

    $studentId =
        trim($_POST["student_id"]);

    $studentName =
        trim($_POST["student_name"]);

    $activityName =
        trim($_POST["activity_name"]);

    $activityDate =
        trim($_POST["activity_date"]);


    /*
     * Validate input fields
     */

    if (
        empty($studentId) ||
        empty($studentName) ||
        empty($activityName) ||
        empty($activityDate)
    ) {

        $message =
            "Please fill in all required fields.";

        $messageType = "error";

    }

    else {

        /*
         * Format the activity date
         */

        $formattedDate =
            date(
                "d-m-Y",
                strtotime($activityDate)
            );


        /*
         * Create activity record
         */

        $record =
            $studentId . "|" .
            $studentName . "|" .
            $activityName . "|" .
            $formattedDate .
            PHP_EOL;


        /*
         * Store activity in text file
         */

        if (
            file_put_contents(
                $fileName,
                $record,
                FILE_APPEND
            ) !== false
        ) {

            /*
             * Store current activity
             * in session
             */

            $_SESSION["student_id"] =
                $studentId;

            $_SESSION["student_name"] =
                $studentName;

            $_SESSION["last_activity"] =
                $activityName;

            $_SESSION["activity_date"] =
                $formattedDate;


            /*
             * Count activities added
             * during the session
             */

            if (
                !isset(
                    $_SESSION["activity_count"]
                )
            ) {

                $_SESSION["activity_count"] = 0;

            }

            $_SESSION["activity_count"]++;


            $message =
                "Student activity stored successfully.";

            $messageType = "success";

        }

        else {

            $message =
                "Unable to store activity information.";

            $messageType = "error";

        }

    }

}


/*
 * GENERATE STUDENT ACTIVITY REPORT
 */

if (
    $_SERVER["REQUEST_METHOD"] == "POST" &&
    $_POST["action"] == "report"
) {

    $searchId =
        trim($_POST["search_id"]);

    $studentActivities = array();

    $studentName = "";


    /*
     * Check whether activity file exists
     */

    if (file_exists($fileName)) {

        /*
         * Read activity records
         */

        $records =
            file(
                $fileName,
                FILE_IGNORE_NEW_LINES
            );


        /*
         * Search activities
         * using Student ID
         */

        foreach ($records as $record) {

            $data =
                explode("|", $record);


            if (
                isset($data[0]) &&
                $data[0] == $searchId
            ) {

                $studentName =
                    $data[1];


                $studentActivities[] = array(
                    "activity" => $data[2],
                    "date" => $data[3]
                );

            }

        }


        /*
         * Store searched student details
         * in session
         */

        $_SESSION["searched_student"] =
            $searchId;

    }


    if (
        count($studentActivities) > 0
    ) {

        $message =
            "Activity report generated successfully.";

        $messageType = "success";

    }

    else {

        $message =
            "No activity records found for this Student ID.";

        $messageType = "error";

    }

}

?>

<!DOCTYPE html>
<html>

<head>

    <title>Student Activity Report</title>

    <link rel="stylesheet"
          href="style.css">

</head>

<body>

<div class="container">

    <h1>Student Activity Report</h1>


<?php

/*
 * Display message
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
 * Display stored activity result
 */

if (
    isset($_POST["action"]) &&
    $_POST["action"] == "add" &&
    $messageType == "success"
) {

?>

<div class="session-box">

    <h2>
        Current Session Activity
    </h2>

    <p>

        <strong>Student ID:</strong>

        <?php
        echo htmlspecialchars(
            $_SESSION["student_id"]
        );
        ?>

    </p>

    <p>

        <strong>Student Name:</strong>

        <?php
        echo htmlspecialchars(
            $_SESSION["student_name"]
        );
        ?>

    </p>

    <p>

        <strong>Last Activity:</strong>

        <?php
        echo htmlspecialchars(
            $_SESSION["last_activity"]
        );
        ?>

    </p>

    <p>

        <strong>Activity Date:</strong>

        <?php
        echo htmlspecialchars(
            $_SESSION["activity_date"]
        );
        ?>

    </p>

    <p>

        <strong>Activities Added in Session:</strong>

        <?php
        echo $_SESSION["activity_count"];
        ?>

    </p>

</div>

<?php

}


/*
 * Display activity report
 */

if (
    isset($studentActivities) &&
    count($studentActivities) > 0
) {

?>

<div class="report-box">

    <h2>
        Learner Activity Summary
    </h2>


    <p>

        <strong>Student ID:</strong>

        <?php
        echo htmlspecialchars(
            $searchId
        );
        ?>

    </p>


    <p>

        <strong>Student Name:</strong>

        <?php
        echo htmlspecialchars(
            $studentName
        );
        ?>

    </p>


    <p>

        <strong>Total Activities:</strong>

        <?php
        echo count(
            $studentActivities
        );
        ?>

    </p>


    <table>

        <tr>

            <th>
                S.No
            </th>

            <th>
                Activity Name
            </th>

            <th>
                Activity Date
            </th>

        </tr>


<?php

$number = 1;

foreach (
    $studentActivities
    as $activity
) {

?>

        <tr>

            <td>

                <?php
                echo $number;
                ?>

            </td>

            <td>

                <?php
                echo htmlspecialchars(
                    $activity["activity"]
                );
                ?>

            </td>

            <td>

                <?php
                echo htmlspecialchars(
                    $activity["date"]
                );
                ?>

            </td>

        </tr>

<?php

    $number++;

}

?>

    </table>

</div>

<?php

}

?>

<br>

<a href="index.php"
   class="back">

    Back to Activity Management

</a>

</div>

</body>

</html>