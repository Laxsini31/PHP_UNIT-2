<?php

$message = "";

$messageType = "";

$documents = [];


/*
 * Secure document directory
 */

$documentDirectory =
    "secure_documents";


/*
 * Create directory if it does not exist
 */

if (!is_dir($documentDirectory)) {

    mkdir(
        $documentDirectory,
        0777,
        true
    );

}


/*
 * Upload document
 */

if (isset($_POST["upload"])) {

    if (
        !isset($_FILES["document"])
        ||
        $_FILES["document"]["error"] != 0
    ) {

        $message =
            "Please select a valid document.";

        $messageType =
            "error";

    }

    else {

        $fileName =
            basename(
                $_FILES["document"]["name"]
            );


        $fileSize =
            $_FILES["document"]["size"];


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
                $documentDirectory .
                "/" .
                $fileName
            )
        ) {

            $message =
                "Duplicate file detected. This document already exists.";

            $messageType =
                "error";

        }

        else {

            $targetFile =
                $documentDirectory .
                "/" .
                $fileName;


            /*
             * Store uploaded file
             */

            if (
                move_uploaded_file(
                    $_FILES["document"]["tmp_name"],
                    $targetFile
                )
            ) {

                $message =
                    "Document uploaded securely.";

                $messageType =
                    "success";

            }

            else {

                $message =
                    "Unable to upload the document.";

                $messageType =
                    "error";

            }

        }

    }

}


/*
 * Retrieve available documents
 */

if (
    isset($_POST["view"])
    ||
    isset($_POST["upload"])
) {

    $documents =
        array_diff(
            scandir(
                $documentDirectory
            ),
            [".", ".."]
        );

}

?>

<!DOCTYPE html>
<html>

<head>

    <title>Secure Document Result</title>

    <link rel="stylesheet"
          href="style.css">

</head>

<body>

<div class="container">

    <h1>Secure Document Management Result</h1>


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

        echo htmlspecialchars(
            $message
        );

        ?>

    </p>

</div>

<?php

}

?>


<?php

if (
    count($documents) > 0
) {

?>

<div class="document-box">

    <h2>Available Documents</h2>


    <table>

        <tr>

            <th>Document Name</th>

            <th>Action</th>

        </tr>


<?php

foreach (
    $documents
    as $document
) {

?>

        <tr>

            <td>

                <?php

                echo htmlspecialchars(
                    $document
                );

                ?>

            </td>


            <td>

                <form action="view_document.php"
                      method="post">

                    <input type="hidden"
                           name="file_name"

                           value="<?php

                           echo htmlspecialchars(
                               $document
                           );

                           ?>">

                    <input type="submit"
                           value="Access">

                </form>

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

<div class="document-box">

    <p>
        No documents are available.
    </p>

</div>

<?php

}

?>


<a href="index.html"
   class="back">

    Back to Document Management

</a>

</div>

</body>

</html>