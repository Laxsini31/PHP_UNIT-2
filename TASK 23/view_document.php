<?php

$documentDirectory =
    "secure_documents";


if (
    !isset($_POST["file_name"])
) {

    die(
        "Unauthorized access detected."
    );

}


$fileName =
    basename(
        $_POST["file_name"]
    );


$filePath =
    $documentDirectory .
    "/" .
    $fileName;


/*
 * Check whether the requested file exists
 */

if (!file_exists($filePath)) {

    die(
        "Unauthorized access or file not found."
    );

}


/*
 * Check allowed file types
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
 * Display the document
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