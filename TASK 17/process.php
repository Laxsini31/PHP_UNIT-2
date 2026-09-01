<?php

$message = "";

$messageType = "";


/*
 * Main directory for departments
 */

$mainDirectory = "departments";


/*
 * Create main directory
 * if it does not exist
 */

if (!is_dir($mainDirectory)) {

    mkdir(
        $mainDirectory,
        0777,
        true
    );

}


/*
 * Check form submission
 */

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $action =
        $_POST["action"];


    /*
     * CREATE FOLDER
     */

    if ($action == "create") {

        $departmentName =
            trim(
                $_POST["department_name"]
            );


        if (empty($departmentName)) {

            $message =
                "Please enter a department name.";

            $messageType =
                "error";

        }

        else {

            $folderPath =
                $mainDirectory .
                "/" .
                $departmentName;


            if (is_dir($folderPath)) {

                $message =
                    "Department folder already exists.";

                $messageType =
                    "error";

            }

            else {

                if (
                    mkdir(
                        $folderPath,
                        0777,
                        true
                    )
                ) {

                    $message =
                        "Department folder created successfully.";

                    $messageType =
                        "success";

                }

                else {

                    $message =
                        "Unable to create department folder.";

                    $messageType =
                        "error";

                }

            }

        }

    }


    /*
     * RENAME FOLDER
     */

    elseif ($action == "rename") {

        $oldName =
            trim(
                $_POST["old_name"]
            );

        $newName =
            trim(
                $_POST["new_name"]
            );


        if (
            empty($oldName) ||
            empty($newName)
        ) {

            $message =
                "Please enter both folder names.";

            $messageType =
                "error";

        }

        else {

            $oldPath =
                $mainDirectory .
                "/" .
                $oldName;

            $newPath =
                $mainDirectory .
                "/" .
                $newName;


            if (!is_dir($oldPath)) {

                $message =
                    "The department folder does not exist.";

                $messageType =
                    "error";

            }

            elseif (is_dir($newPath)) {

                $message =
                    "A folder with the new name already exists.";

                $messageType =
                    "error";

            }

            else {

                if (
                    rename(
                        $oldPath,
                        $newPath
                    )
                ) {

                    $message =
                        "Department folder renamed successfully.";

                    $messageType =
                        "success";

                }

                else {

                    $message =
                        "Unable to rename the department folder.";

                    $messageType =
                        "error";

                }

            }

        }

    }


    /*
     * DELETE FOLDER
     */

    elseif ($action == "delete") {

        $deleteName =
            trim(
                $_POST["delete_name"]
            );


        if (empty($deleteName)) {

            $message =
                "Please enter a department name.";

            $messageType =
                "error";

        }

        else {

            $folderPath =
                $mainDirectory .
                "/" .
                $deleteName;


            if (!is_dir($folderPath)) {

                $message =
                    "Department folder does not exist.";

                $messageType =
                    "error";

            }

            else {

                /*
                 * Delete only empty folders
                 */

                if (rmdir($folderPath)) {

                    $message =
                        "Department folder deleted successfully.";

                    $messageType =
                        "success";

                }

                else {

                    $message =
                        "Folder cannot be deleted because it is not empty.";

                    $messageType =
                        "error";

                }

            }

        }

    }

}


/*
 * Display available department folders
 */

$departmentFolders =
    scandir($mainDirectory);


/*
 * Remove . and ..
 */

$departmentFolders =
    array_diff(
        $departmentFolders,
        array(".", "..")
    );

?>

<!DOCTYPE html>
<html>

<head>

    <title>Directory Management Result</title>

    <link rel="stylesheet"
          href="style.css">

</head>

<body>

<div class="container">

    <h1>Directory Management Result</h1>


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


<div class="folder-box">

    <h2>
        Available Department Folders
    </h2>


<?php

if (count($departmentFolders) > 0) {

?>

    <table>

        <tr>

            <th>
                Folder Name
            </th>

        </tr>


<?php

foreach (
    $departmentFolders
    as $folder
) {

?>

        <tr>

            <td>

                <?php
                echo htmlspecialchars(
                    $folder
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
        No department folders available.
    </p>

<?php

}

?>

</div>


<a href="index.html"
   class="back">

    Back to Directory Management

</a>

</div>

</body>

</html>