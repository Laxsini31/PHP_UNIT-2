<?php

$message = "";

$messageType = "";

$reportFiles = [];


/*
 * Main reports directory
 */

$mainDirectory = "reports";


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
 * Report folders
 */

$folders = [

    "student_reports",

    "employee_reports",

    "sales_reports"

];


/*
 * Create report folders
 */

foreach (
    $folders
    as $folder
) {

    $folderPath =
        $mainDirectory .
        "/" .
        $folder;


    if (!is_dir($folderPath)) {

        mkdir(
            $folderPath,
            0777,
            true
        );

    }

}


/*
 * Check form submission
 */

if (
    $_SERVER["REQUEST_METHOD"] == "POST"
) {

    $selectedFolder =
        $_POST["folder"];


    /*
     * Validate selected folder
     */

    if (
        empty($selectedFolder)
    ) {

        $message =
            "Please select a report folder.";

        $messageType =
            "error";

    }

    elseif (
        !in_array(
            $selectedFolder,
            $folders
        )
    ) {

        $message =
            "Invalid report folder selected.";

        $messageType =
            "error";

    }

    else {

        $selectedPath =
            $mainDirectory .
            "/" .
            $selectedFolder;


        /*
         * Read files from selected folder
         */

        $reportFiles =
            array_diff(
                scandir(
                    $selectedPath
                ),
                [".", ".."]
            );


        if (
            count($reportFiles) > 0
        ) {

            $message =
                "Reports retrieved successfully.";

            $messageType =
                "success";

        }

        else {

            $message =
                "No reports are available in this folder.";

            $messageType =
                "error";

        }

    }

}

?>

<!DOCTYPE html>
<html>

<head>

    <title>Report Access Result</title>

    <link rel="stylesheet"
          href="style.css">

</head>

<body>

<div class="container">

    <h1>Report File Access Result</h1>


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
    count($reportFiles) > 0
) {

?>

<div class="report-box">

    <h2>Available Reports</h2>


    <table>

        <tr>

            <th>
                Report File
            </th>

            <th>
                Action
            </th>

        </tr>


<?php

foreach (
    $reportFiles
    as $file
) {

    $filePath =
        $mainDirectory .
        "/" .
        $selectedFolder .
        "/" .
        $file;

?>

        <tr>

            <td>

                <?php

                echo htmlspecialchars(
                    $file
                );

                ?>

            </td>


            <td>

                <a href="<?php

                echo htmlspecialchars(
                    $filePath
                );

                ?>"

                target="_blank"

                class="access">

                    Access Report

                </a>

            </td>

        </tr>

<?php

}

?>

    </table>

</div>

<?php

}

?>


<a href="index.html"
   class="back">

    Back to Report Categories

</a>

</div>

</body>

</html>