<?php

session_start();


/*
 * Check authentication
 */

if (
    !isset($_SESSION["authenticated"])
    ||
    $_SESSION["authenticated"] !== true
) {

    header(
        "Location: index.php"
    );

    exit;

}


$message = "";

$messageType = "";


/*
 * Medical record directory
 */

$recordDirectory =
    "medical_records";


if (!is_dir($recordDirectory)) {

    mkdir(
        $recordDirectory,
        0777,
        true
    );

}


/*
 * Process uploaded file
 */

if (
    isset($_POST["upload"])
    &&
    isset($_FILES["medical_file"])
) {

    if (
        $_FILES["medical_file"]["error"] != 0
    ) {

        $message =
            "Please select a valid medical report.";

        $messageType =
            "error";

    }

    else {

        $fileName =
            basename(
                $_FILES["medical_file"]["name"]
            );


        $fileSize =
            $_FILES["medical_file"]["size"];


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

            "txt"

        ];


        /*
         * Validate file type
         */

        if (
            !in_array(
                $fileExtension,
                $allowedFiles
            )
        ) {

            $message =
                "Invalid file type. Only PDF and TXT files are allowed.";

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
                "File size exceeds the maximum limit of 2 MB.";

            $messageType =
                "error";

        }


        /*
         * Prevent duplicate files
         */

        elseif (
            file_exists(
                $recordDirectory .
                "/" .
                $fileName
            )
        ) {

            $message =
                "This medical record already exists.";

            $messageType =
                "error";

        }

        else {

            $targetFile =
                $recordDirectory .
                "/" .
                $fileName;


            if (
                move_uploaded_file(
                    $_FILES["medical_file"]["tmp_name"],
                    $targetFile
                )
            ) {

                $message =
                    "Medical record uploaded successfully.";

                $messageType =
                    "success";

            }

            else {

                $message =
                    "Unable to upload the medical record.";

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

    <title>Upload Result</title>

    <link rel="stylesheet"
          href="style.css">

</head>

<body>

<div class="container">

    <h1>Medical Record Upload Result</h1>


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


<a href="dashboard.php"
   class="back">

    Back to Dashboard

</a>

</div>

</body>

</html>