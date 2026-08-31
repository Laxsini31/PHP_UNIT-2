<?php

$fileName = "students.txt";

$message = "";
$messageType = "";

$studentRecords = array();


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $studentId =
        trim($_POST["student_id"]);

    $studentName =
        trim($_POST["student_name"]);

    $department =
        $_POST["department"];

    $year =
        $_POST["year"];


    /*
     * Validate input fields
     */

    if (
        empty($studentId) ||
        empty($studentName) ||
        empty($department) ||
        empty($year)
    ) {

        $message =
            "Please fill in all required fields.";

        $messageType = "error";

    }

    else {

        /*
         * Create student record
         */

        $record =
            $studentId . "|" .
            $studentName . "|" .
            $department . "|" .
            $year .
            PHP_EOL;


        /*
         * Append the new student record
         * to the existing text file
         */

        if (
            file_put_contents(
                $fileName,
                $record,
                FILE_APPEND
            ) !== false
        ) {

            $message =
                "Student record added successfully.";

            $messageType = "success";

        }

        else {

            $message =
                "Unable to update student records.";

            $messageType = "error";

        }

    }

}


/*
 * Read updated student records
 */

if (file_exists($fileName)) {

    $records =
        file(
            $fileName,
            FILE_IGNORE_NEW_LINES
        );


    foreach ($records as $record) {

        if (!empty(trim($record))) {

            $data =
                explode("|", $record);


            if (count($data) == 4) {

                $studentRecords[] = array(

                    "id" =>
                        $data[0],

                    "name" =>
                        $data[1],

                    "department" =>
                        $data[2],

                    "year" =>
                        $data[3]

                );

            }

        }

    }

}

?>

<!DOCTYPE html>
<html>

<head>

    <title>Updated Student Records</title>

    <link rel="stylesheet"
          href="style.css">

</head>

<body>

<div class="container">

    <h1>Updated Student Records</h1>


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

?>


<?php

/*
 * Display updated student records
 */

if (count($studentRecords) > 0) {

?>

<div class="records-box">

    <h2>
        Student Records
    </h2>

    <p>

        <strong>
            Total Students:
        </strong>

        <?php
        echo count($studentRecords);
        ?>

    </p>


    <table>

        <tr>

            <th>
                Student ID
            </th>

            <th>
                Student Name
            </th>

            <th>
                Department
            </th>

            <th>
                Year
            </th>

        </tr>


<?php

foreach (
    $studentRecords
    as $student
) {

?>

        <tr>

            <td>

                <?php
                echo htmlspecialchars(
                    $student["id"]
                );
                ?>

            </td>


            <td>

                <?php
                echo htmlspecialchars(
                    $student["name"]
                );
                ?>

            </td>


            <td>

                <?php
                echo htmlspecialchars(
                    $student["department"]
                );
                ?>

            </td>


            <td>

                <?php
                echo htmlspecialchars(
                    $student["year"]
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

else {

?>

<div class="error-box">

    <h2 class="error">
        No Records Found
    </h2>

    <p>
        Student records are not available.
    </p>

</div>

<?php

}

?>

<br>

<a href="index.html"
   class="back">

    Add Another Student

</a>

</div>

</body>

</html>