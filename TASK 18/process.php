<?php

date_default_timezone_set(
    "Asia/Kolkata"
);

$message = "";

$messageType = "";

$backupFileName = "";

$backupTime = "";


/*
 * Check form submission
 */

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $studentName =
        trim($_POST["student_name"]);

    $registerNumber =
        trim($_POST["register_number"]);

    $department =
        trim($_POST["department"]);

    $year =
        trim($_POST["year"]);


    /*
     * Validate input fields
     */

    if (
        empty($studentName) ||
        empty($registerNumber) ||
        empty($department) ||
        empty($year)
    ) {

        $message =
            "Please fill in all required fields.";

        $messageType =
            "error";

    }

    else {

        /*
         * Create student record
         */

        $studentRecord =
            "Student Name: " .
            $studentName .
            PHP_EOL .

            "Register Number: " .
            $registerNumber .
            PHP_EOL .

            "Department: " .
            $department .
            PHP_EOL .

            "Year: " .
            $year .
            PHP_EOL .

            "Record Created: " .
            date("d-m-Y h:i:s A") .
            PHP_EOL .

            "-----------------------------------" .
            PHP_EOL;


        /*
         * Main student records file
         */

        $recordFile =
            "student_records.txt";


        /*
         * Store student record
         */

        file_put_contents(
            $recordFile,
            $studentRecord,
            FILE_APPEND
        );


        /*
         * Create backup directory
         */

        $backupDirectory =
            "backups";


        if (!is_dir($backupDirectory)) {

            mkdir(
                $backupDirectory,
                0777,
                true
            );

        }


        /*
         * Generate unique backup filename
         */

        $timeStamp =
            date("Ymd_His");


        $backupFileName =
            "student_backup_" .
            $timeStamp .
            ".txt";


        $backupFilePath =
            $backupDirectory .
            "/" .
            $backupFileName;


        /*
         * Read original records
         */

        $records =
            file_get_contents(
                $recordFile
            );


        /*
         * Create backup file
         */

        if (
            file_put_contents(
                $backupFilePath,
                $records
            ) !== false
        ) {

            /*
             * Store backup timestamp
             */

            $backupTime =
                date("d-m-Y h:i:s A");


            /*
             * Record backup information
             */

            $backupLog =
                "Backup File: " .
                $backupFileName .
                " | Backup Time: " .
                $backupTime .
                PHP_EOL;


            file_put_contents(
                "backup_log.txt",
                $backupLog,
                FILE_APPEND
            );


            $message =
                "Student record saved and backup created successfully.";

            $messageType =
                "success";

        }

        else {

            $message =
                "Student record saved, but backup creation failed.";

            $messageType =
                "error";

        }

    }

}

?>

<!DOCTYPE html>
<html>

<head>

    <title>Backup Result</title>

    <link rel="stylesheet"
          href="style.css">

</head>

<body>

<div class="container">

    <h1>Student Records Backup Result</h1>


<?php

if (!empty($message)) {

?>

<div class="<?php

echo $messageType == "success"
    ? "success-box"
    : "error-box";

?>">

    <h2>

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

?>


<?php

if ($messageType == "success") {

?>

<div class="result-box">

    <h2>Backup Information</h2>

    <p>

        <strong>Student Name:</strong>

        <?php
        echo htmlspecialchars(
            $studentName
        );
        ?>

    </p>


    <p>

        <strong>Register Number:</strong>

        <?php
        echo htmlspecialchars(
            $registerNumber
        );
        ?>

    </p>


    <p>

        <strong>Backup File:</strong>

        <?php
        echo htmlspecialchars(
            $backupFileName
        );
        ?>

    </p>


    <p>

        <strong>Backup Time:</strong>

        <?php
        echo $backupTime;
        ?>

    </p>

</div>

<?php

}

?>


<a href="index.html"
   class="back">

    Add Another Student Record

</a>

</div>

</body>

</html>