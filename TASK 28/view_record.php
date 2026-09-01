<?php

session_start();


/*
 * Prevent unauthorized access
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


/*
 * Check requested file
 */

if (
    !isset($_POST["file_name"])
) {

    die(
        "Unauthorized access."
    );

}


$fileName =
    basename(
        $_POST["file_name"]
    );


$recordDirectory =
    "medical_records";


$filePath =
    $recordDirectory .
    "/" .
    $fileName;


/*
 * Validate file existence
 */

if (
    !file_exists($filePath)
) {

    die(
        "Medical record not found."
    );

}


/*
 * Validate file extension
 */

$fileExtension =
    strtolower(
        pathinfo(
            $fileName,
            PATHINFO_EXTENSION
        )
    );


$allowedFiles = [

    "pdf",

    "txt"

];


if (
    !in_array(
        $fileExtension,
        $allowedFiles
    )
) {

    die(
        "Unauthorized file access."
    );

}


/*
 * Display selected record
 */

header(
    "Content-Type: application/octet-stream"
);


header(
    "Content-Disposition: inline; filename="
    . basename($fileName)
);


readfile(
    $filePath
);

exit;

?>