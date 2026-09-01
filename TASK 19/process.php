<?php

$message = "";

$messageType = "";

$filesFound = [];


/*
 * Create main multimedia directory
 */

$mainDirectory = "multimedia";


if (!is_dir($mainDirectory)) {

    mkdir(
        $mainDirectory,
        0777,
        true
    );

}


/*
 * Create image directory
 */

$imageDirectory =
    $mainDirectory . "/images";


if (!is_dir($imageDirectory)) {

    mkdir(
        $imageDirectory,
        0777,
        true
    );

}


/*
 * Create video directory
 */

$videoDirectory =
    $mainDirectory . "/videos";


if (!is_dir($videoDirectory)) {

    mkdir(
        $videoDirectory,
        0777,
        true
    );

}


/*
 * Upload multimedia file
 */

if (
    isset($_POST["upload"])
) {

    $category =
        $_POST["category"];


    if (
        empty($category) ||
        !isset($_FILES["multimedia_file"])
    ) {

        $message =
            "Please select a file and category.";

        $messageType =
            "error";

    }

    else {

        $fileName =
            basename(
                $_FILES["multimedia_file"]["name"]
            );


        $fileExtension =
            strtolower(
                pathinfo(
                    $fileName,
                    PATHINFO_EXTENSION
                )
            );


        /*
         * Allowed image formats
         */

        $allowedImages =
            ["jpg", "jpeg", "png", "gif"];


        /*
         * Allowed video formats
         */

        $allowedVideos =
            ["mp4", "avi", "mov"];


        $targetDirectory = "";


        /*
         * Validate category
         * and file type
         */

        if ($category == "images") {

            if (
                !in_array(
                    $fileExtension,
                    $allowedImages
                )
            ) {

                $message =
                    "Please upload a valid image file.";

                $messageType =
                    "error";

            }

            else {

                $targetDirectory =
                    $imageDirectory;

            }

        }

        elseif ($category == "videos") {

            if (
                !in_array(
                    $fileExtension,
                    $allowedVideos
                )
            ) {

                $message =
                    "Please upload a valid video file.";

                $messageType =
                    "error";

            }

            else {

                $targetDirectory =
                    $videoDirectory;

            }

        }


        /*
         * Move uploaded file
         */

        if (
            $messageType != "error" &&
            !empty($targetDirectory)
        ) {

            $targetFile =
                $targetDirectory .
                "/" .
                $fileName;


            if (
                move_uploaded_file(
                    $_FILES[
                        "multimedia_file"
                    ]["tmp_name"],
                    $targetFile
                )
            ) {

                $message =
                    "Multimedia file uploaded successfully.";

                $messageType =
                    "success";

            }

            else {

                $message =
                    "Unable to upload the file.";

                $messageType =
                    "error";

            }

        }

    }

}


/*
 * Search multimedia files
 */

if (
    isset($_POST["search"])
) {

    $searchFile =
        trim(
            $_POST["search_file"]
        );


    if (empty($searchFile)) {

        $message =
            "Please enter a file name to search.";

        $messageType =
            "error";

    }

    else {

        /*
         * Search in images
         */

        $imageFiles =
            array_diff(
                scandir($imageDirectory),
                [".", ".."]
            );


        /*
         * Search in videos
         */

        $videoFiles =
            array_diff(
                scandir($videoDirectory),
                [".", ".."]
            );


        /*
         * Combine all multimedia files
         */

        $allFiles =
            array_merge(
                $imageFiles,
                $videoFiles
            );


        /*
         * Find matching files
         */

        foreach (
            $allFiles
            as $file
        ) {

            if (
                stripos(
                    $file,
                    $searchFile
                ) !== false
            ) {

                $filesFound[] =
                    $file;

            }

        }


        if (
            count($filesFound) > 0
        ) {

            $message =
                "Matching multimedia files found.";

            $messageType =
                "success";

        }

        else {

            $message =
                "No matching multimedia files found.";

            $messageType =
                "error";

        }

    }

}


/*
 * Get all available files
 */

$imageFiles =
    array_diff(
        scandir($imageDirectory),
        [".", ".."]
    );


$videoFiles =
    array_diff(
        scandir($videoDirectory),
        [".", ".."]
    );

?>

<!DOCTYPE html>
<html>

<head>

    <title>Multimedia File Result</title>

    <link rel="stylesheet"
          href="style.css">

</head>

<body>

<div class="container">

    <h1>Multimedia File Management Result</h1>


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

if (
    count($filesFound) > 0
) {

?>

<div class="file-box">

    <h2>Search Results</h2>

    <ul>

<?php

foreach (
    $filesFound
    as $file
) {

?>

        <li>

            <?php
            echo htmlspecialchars($file);
            ?>

        </li>

<?php

}

?>

    </ul>

</div>

<?php

}

?>


<div class="file-box">

    <h2>Available Images</h2>

<?php

if (count($imageFiles) > 0) {

?>

    <ul>

<?php

foreach (
    $imageFiles
    as $file
) {

?>

        <li>

            <?php
            echo htmlspecialchars($file);
            ?>

        </li>

<?php

}

?>

    </ul>

<?php

}

else {

?>

    <p>No image files available.</p>

<?php

}

?>

</div>


<div class="file-box">

    <h2>Available Videos</h2>

<?php

if (count($videoFiles) > 0) {

?>

    <ul>

<?php

foreach (
    $videoFiles
    as $file
) {

?>

        <li>

            <?php
            echo htmlspecialchars($file);
            ?>

        </li>

<?php

}

?>

    </ul>

<?php

}

else {

?>

    <p>No video files available.</p>

<?php

}

?>

</div>


<a href="index.html"
   class="back">

    Back to Multimedia Management

</a>

</div>

</body>

</html>