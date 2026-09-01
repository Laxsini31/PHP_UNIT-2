<?php

$message = "";

$messageType = "";

$allDocuments = [];


/*
 * Main cloud directory
 */

$mainDirectory = "cloud_documents";


/*
 * Create main directory
 */

if (!is_dir($mainDirectory)) {

    mkdir(
        $mainDirectory,
        0777,
        true
    );

}


/*
 * Define document directories
 */

$directories = [
    "reports",
    "assignments",
    "documents"
];


/*
 * Create subdirectories
 */

foreach ($directories as $directory) {

    $path =
        $mainDirectory .
        "/" .
        $directory;

    if (!is_dir($path)) {

        mkdir(
            $path,
            0777,
            true
        );

    }

}


/*
 * Upload document
 */

if (isset($_POST["upload"])) {

    $category =
        $_POST["category"];


    if (
        empty($category) ||
        !isset($_FILES["document"])
    ) {

        $message =
            "Please select a document and directory.";

        $messageType =
            "error";

    }

    else {

        $fileName =
            basename(
                $_FILES["document"]["name"]
            );


        $fileExtension =
            strtolower(
                pathinfo(
                    $fileName,
                    PATHINFO_EXTENSION
                )
            );


        /*
         * Allowed document formats
         */

        $allowedFiles = [
            "pdf",
            "doc",
            "docx",
            "txt"
        ];


        if (
            !in_array(
                $fileExtension,
                $allowedFiles
            )
        ) {

            $message =
                "Invalid file type. Upload PDF, DOC, DOCX, or TXT files.";

            $messageType =
                "error";

        }

        else {

            $targetDirectory =
                $mainDirectory .
                "/" .
                $category;


            $targetFile =
                $targetDirectory .
                "/" .
                $fileName;


            if (
                move_uploaded_file(
                    $_FILES["document"]["tmp_name"],
                    $targetFile
                )
            ) {

                $message =
                    "Document uploaded successfully.";

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
 * Delete document
 */

if (isset($_POST["delete"])) {

    $fileName =
        trim(
            $_POST["file_name"]
        );


    $fileFound = false;


    foreach (
        $directories
        as $directory
    ) {

        $filePath =
            $mainDirectory .
            "/" .
            $directory .
            "/" .
            $fileName;


        if (file_exists($filePath)) {

            if (unlink($filePath)) {

                $message =
                    "Document deleted successfully.";

                $messageType =
                    "success";

            }

            else {

                $message =
                    "Unable to delete the document.";

                $messageType =
                    "error";

            }

            $fileFound = true;

            break;

        }

    }


    if (!$fileFound) {

        $message =
            "Document not found.";

        $messageType =
            "error";

    }

}


/*
 * Retrieve all stored documents
 */

foreach (
    $directories
    as $directory
) {

    $directoryPath =
        $mainDirectory .
        "/" .
        $directory;


    $files =
        array_diff(
            scandir($directoryPath),
            [".", ".."]
        );


    foreach (
        $files
        as $file
    ) {

        $allDocuments[] = [
            "name" => $file,
            "directory" => $directory
        ];

    }

}

?>

<!DOCTYPE html>
<html>

<head>

    <title>Cloud Document Result</title>

    <link rel="stylesheet"
          href="style.css">

</head>

<body>

<div class="container">

    <h1>Cloud Document Management Result</h1>


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


<div class="document-box">

    <h2>Stored Documents</h2>


<?php

if (count($allDocuments) > 0) {

?>

<table>

    <tr>

        <th>File Name</th>

        <th>Directory</th>

    </tr>


<?php

foreach (
    $allDocuments
    as $document
) {

?>

    <tr>

        <td>

            <?php
            echo htmlspecialchars(
                $document["name"]
            );
            ?>

        </td>


        <td>

            <?php
            echo htmlspecialchars(
                ucfirst(
                    $document["directory"]
                )
            );
            ?>

        </td>

    </tr>

<?php

}

?>

</table>

<?php

}

else {

?>

<p>
    No documents are currently available.
</p>

<?php

}

?>

</div>


<a href="index.html"
   class="back">

    Back to Document Management

</a>

</div>

</body>

</html>