<?php

$message = "";
$messageType = "";

$fileName = "attendance.txt";


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $action = $_POST["action"];


    /*
     * STORE ATTENDANCE RECORD
     */

    if ($action == "store") {

        $employeeId =
            trim($_POST["employee_id"]);

        $employeeName =
            trim($_POST["employee_name"]);

        $attendanceDate =
            trim($_POST["attendance_date"]);

        $status =
            $_POST["status"];


        // Validate input fields

        if (
            empty($employeeId) ||
            empty($employeeName) ||
            empty($attendanceDate) ||
            empty($status)
        ) {

            $message =
                "Please fill in all required fields.";

            $messageType = "error";

        }

        else {

            // Create attendance record

            $record =
                $employeeId . "|" .
                $employeeName . "|" .
                $attendanceDate . "|" .
                $status .
                PHP_EOL;


            // Store record in text file

            if (
                file_put_contents(
                    $fileName,
                    $record,
                    FILE_APPEND
                ) !== false
            ) {

                $message =
                    "Employee attendance stored successfully.";

                $messageType = "success";

            }

            else {

                $message =
                    "Unable to store attendance record.";

                $messageType = "error";

            }

        }

    }


    /*
     * RETRIEVE ATTENDANCE RECORDS
     */

    elseif ($action == "view") {

        if (file_exists($fileName)) {

            $records =
                file(
                    $fileName,
                    FILE_IGNORE_NEW_LINES
                );

            $attendanceRecords = array();


            foreach ($records as $record) {

                if (!empty(trim($record))) {

                    $data =
                        explode("|", $record);

                    $attendanceRecords[] = array(
                        "id" => $data[0],
                        "name" => $data[1],
                        "date" => $data[2],
                        "status" => $data[3]
                    );

                }

            }

        }

        else {

            $message =
                "No attendance records found.";

            $messageType = "error";

        }

    }

}

?>

<!DOCTYPE html>
<html>

<head>

    <title>Attendance Record Result</title>

    <link rel="stylesheet"
          href="style.css">

</head>

<body>

<div class="container">

    <h1>Employee Attendance Records</h1>


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
 * Display stored attendance records
 */

if (
    isset($attendanceRecords) &&
    count($attendanceRecords) > 0
) {

?>

<div class="success-box">

    <h2 class="success">
        Attendance Records Retrieved Successfully!
    </h2>


    <table>

        <tr>
            <th>Employee ID</th>
            <th>Employee Name</th>
            <th>Date</th>
            <th>Attendance Status</th>
        </tr>


        <?php

        foreach (
            $attendanceRecords
            as $attendance
        ) {

        ?>

        <tr>

            <td>
                <?php
                echo htmlspecialchars(
                    $attendance["id"]
                );
                ?>
            </td>

            <td>
                <?php
                echo htmlspecialchars(
                    $attendance["name"]
                );
                ?>
            </td>

            <td>
                <?php
                echo htmlspecialchars(
                    $attendance["date"]
                );
                ?>
            </td>

            <td>
                <?php
                echo htmlspecialchars(
                    $attendance["status"]
                );
                ?>
            </td>

        </tr>

        <?php

        }

        ?>

    </table>

</div>

<?php

}

?>

<br>

<a href="index.html" class="back">
    Back to Attendance Management
</a>

</div>

</body>

</html>