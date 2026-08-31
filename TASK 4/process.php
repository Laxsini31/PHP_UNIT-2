<?php

$message = "";
$messageType = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $studentName =
        trim($_POST["student_name"]);

    $registerNumber =
        trim($_POST["register_number"]);

    $department =
        $_POST["department"];


    // Check required fields

    if (
        empty($studentName) ||
        empty($registerNumber) ||
        empty($department)
    ) {

        $message =
            "Please fill in all required fields.";

        $messageType = "error";

    }


    // Check whether file is uploaded

    elseif (
        !isset($_FILES["assignment"]) ||
        $_FILES["assignment"]["error"] != 0
    ) {

        $message =
            "Please select a valid assignment file.";

        $messageType = "error";

    }


    else {

        // Get uploaded file details

        $fileName =
            $_FILES["assignment"]["name"];

        $temporaryFile =
            $_FILES["assignment"]["tmp_name"];

        $fileSize =
            $_FILES["assignment"]["size"];


        // Get file extension

        $fileExtension =
            strtolower(
                pathinfo(
                    $fileName,
                    PATHINFO_EXTENSION
                )
            );


        // Allowed file types

        $allowedTypes = array(
            "pdf",
            "docx",
            "txt"
        );


        // Validate file type

        if (
            !in_array(
                $fileExtension,
                $allowedTypes
            )
        ) {

            $message =
                "Invalid file type. Please upload PDF, DOCX or TXT files only.";

            $messageType = "error";

        }


        // Validate file size

        elseif ($fileSize > 5 * 1024 * 1024) {

            $message =
                "File size should not exceed 5 MB.";

            $messageType = "error";

        }


        else {

            // Create department-wise upload directory

            $uploadDirectory =
                "uploads/" . $department;


            if (!is_dir($uploadDirectory)) {

                mkdir(
                    $uploadDirectory,
                    0777,
                    true
                );

            }


            // Create a unique file name

            $newFileName =
                $registerNumber .
                "_" .
                time() .
                "." .
                $fileExtension;


            $destination =
                $uploadDirectory .
                "/" .
                $newFileName;


            // Move uploaded file

            if (
                move_uploaded_file(
                    $temporaryFile,
                    $destination
                )
            ) {

                $message =
                    "Assignment uploaded successfully.";

                $messageType = "success";

            }

            else {

                $message =
                    "Unable to upload the assignment.";

                $messageType = "error";

            }

        }

    }

}

?>

<!DOCTYPE html>
<html>

<head>

    <title>Assignment Upload Result</title>

    <link rel="stylesheet"
          href="style.css">

</head>

<body>

<div class="container">

    <h1>Assignment Submission Result</h1>

<?php

if ($messageType == "success") {

?>

<div class="success-box">

    <h2 class="success">
        Assignment Submitted Successfully!
    </h2>

    <table>

        <tr>
            <th>Details</th>
            <th>Information</th>
        </tr>

        <tr>
            <td>Student Name</td>

            <td>
                <?php
                echo htmlspecialchars(
                    $studentName
                );
                ?>
            </td>
        </tr>

        <tr>
            <td>Register Number</td>

            <td>
                <?php
                echo htmlspecialchars(
                    $registerNumber
                );
                ?>
            </td>
        </tr>

        <tr>
            <td>Department</td>

            <td>
                <?php
                echo htmlspecialchars(
                    $department
                );
                ?>
            </td>
        </tr>

        <tr>
            <td>Original File Name</td>

            <td>
                <?php
                echo htmlspecialchars(
                    $fileName
                );
                ?>
            </td>
        </tr>

        <tr>
            <td>File Type</td>

            <td>
                <?php
                echo strtoupper(
                    $fileExtension
                );
                ?>
            </td>
        </tr>

        <tr>
            <td>Storage Location</td>

            <td>
                <?php
                echo htmlspecialchars(
                    $destination
                );
                ?>
            </td>
        </tr>

    </table>

</div>

<?php

}

else {

?>

<div class="error-box">

    <h2 class="error">
        Assignment Submission Failed!
    </h2>

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

<br>

<a href="index.php" class="back">
    Submit Another Assignment
</a>

</div>

</body>

</html>