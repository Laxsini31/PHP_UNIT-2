<?php

$message = "";

$messageType = "";

$fileName = "";


/*
 * Check form submission
 */

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $applicantName =
        trim(
            $_POST["applicant_name"]
        );


    /*
     * Check applicant name
     */

    if (empty($applicantName)) {

        $message =
            "Please enter the applicant name.";

        $messageType =
            "error";

    }


    /*
     * Check uploaded file
     */

    elseif (
        !isset($_FILES["resume"])
        ||
        $_FILES["resume"]["error"] != 0
    ) {

        $message =
            "Please select a valid resume file.";

        $messageType =
            "error";

    }

    else {

        $fileName =
            basename(
                $_FILES["resume"]["name"]
            );


        $fileSize =
            $_FILES["resume"]["size"];


        $fileExtension =
            strtolower(
                pathinfo(
                    $fileName,
                    PATHINFO_EXTENSION
                )
            );


        /*
         * Allowed file types
         */

        $allowedFiles = [
            "pdf",
            "docx"
        ];


        /*
         * Validate file extension
         */

        if (
            !in_array(
                $fileExtension,
                $allowedFiles
            )
        ) {

            $message =
                "Invalid file type. Please upload only PDF or DOCX files.";

            $messageType =
                "error";

        }


        /*
         * Validate file size
         */

        elseif (
            $fileSize >
            2 * 1024 * 1024
        ) {

            $message =
                "File size is too large. Maximum allowed size is 2 MB.";

            $messageType =
                "error";

        }

        else {

            /*
             * Create resumes directory
             */

            $uploadDirectory =
                "resumes";


            if (!is_dir($uploadDirectory)) {

                mkdir(
                    $uploadDirectory,
                    0777,
                    true
                );

            }


            /*
             * Set upload path
             */

            $targetFile =
                $uploadDirectory .
                "/" .
                $fileName;


            /*
             * Upload resume
             */

            if (
                move_uploaded_file(
                    $_FILES["resume"]["tmp_name"],
                    $targetFile
                )
            ) {

                $message =
                    "Resume uploaded and validated successfully.";

                $messageType =
                    "success";

            }

            else {

                $message =
                    "Unable to upload the resume.";

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

    <title>Resume Upload Result</title>

    <link rel="stylesheet"
          href="style.css">

</head>

<body>

<div class="container">

    <h1>Resume Upload Result</h1>


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

    <h2>Resume Details</h2>

    <p>

        <strong>Applicant Name:</strong>

        <?php
        echo htmlspecialchars(
            $applicantName
        );
        ?>

    </p>


    <p>

        <strong>File Name:</strong>

        <?php
        echo htmlspecialchars(
            $fileName
        );
        ?>

    </p>


    <p>

        <strong>Status:</strong>

        Resume is valid and uploaded successfully.

    </p>

</div>

<?php

}

?>


<a href="index.html"
   class="back">

    Upload Another Resume

</a>

</div>

</body>

</html>