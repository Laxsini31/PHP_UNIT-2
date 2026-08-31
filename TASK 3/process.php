<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $action = $_POST["action"];

    /*
     * Department file names
     */

    $departmentFiles = array(
        "Cardiology" => "cardiology.txt",
        "Neurology" => "neurology.txt",
        "Orthopedics" => "orthopedics.txt"
    );


    /*
     * STORE PATIENT RECORD
     */

    if ($action == "store") {

        $patientId =
            trim($_POST["patient_id"]);

        $patientName =
            trim($_POST["patient_name"]);

        $age =
            trim($_POST["age"]);

        $department =
            $_POST["department"];

        $diagnosis =
            trim($_POST["diagnosis"]);


        if (
            empty($patientId) ||
            empty($patientName) ||
            empty($age) ||
            empty($department) ||
            empty($diagnosis)
        ) {

            $message =
                "Please fill in all required fields.";

            $messageType = "error";

        }

        else {

            /*
             * Select department file
             */

            $fileName =
                $departmentFiles[$department];


            /*
             * Create patient record
             */

            $record =
                $patientId . "|" .
                $patientName . "|" .
                $age . "|" .
                $diagnosis . PHP_EOL;


            /*
             * Store record in department file
             */

            file_put_contents(
                $fileName,
                $record,
                FILE_APPEND
            );


            $message =
                "Patient record stored successfully.";

            $messageType = "success";

        }

    }


    /*
     * SEARCH PATIENT RECORD
     */

    elseif ($action == "search") {

        $searchId =
            trim($_POST["search_id"]);

        $found = false;

        $patientRecord = array();


        /*
         * Search all department files
         */

        foreach ($departmentFiles as $department => $fileName) {

            if (file_exists($fileName)) {

                $records =
                    file(
                        $fileName,
                        FILE_IGNORE_NEW_LINES
                    );


                foreach ($records as $record) {

                    $data =
                        explode("|", $record);


                    if (
                        isset($data[0]) &&
                        $data[0] == $searchId
                    ) {

                        $patientRecord = array(
                            "id" => $data[0],
                            "name" => $data[1],
                            "age" => $data[2],
                            "diagnosis" => $data[3],
                            "department" => $department
                        );

                        $found = true;

                        break 2;

                    }

                }

            }

        }


        if (!$found) {

            $message =
                "Patient record not found.";

            $messageType = "error";

        }

    }

}

?>

<!DOCTYPE html>
<html>

<head>

    <title>Patient Record Result</title>

    <link rel="stylesheet" href="style.css">

</head>

<body>

<div class="container">

    <h1>Patient Record Result</h1>

<?php

/*
 * Display store result
 */

if (
    isset($message) &&
    $messageType == "success"
) {

?>

<div class="success-box">

    <h2 class="success">
        Success!
    </h2>

    <p>
        <?php
        echo htmlspecialchars($message);
        ?>
    </p>

    <p>
        Patient ID:
        <?php
        echo htmlspecialchars($patientId);
        ?>
    </p>

    <p>
        Department:
        <?php
        echo htmlspecialchars($department);
        ?>
    </p>

</div>

<?php

}


/*
 * Display error
 */

elseif (
    isset($message) &&
    $messageType == "error"
) {

?>

<div class="error-box">

    <h2 class="error">
        Error!
    </h2>

    <p>
        <?php
        echo htmlspecialchars($message);
        ?>
    </p>

</div>

<?php

}


/*
 * Display searched patient record
 */

if (isset($found) && $found) {

?>

<div class="success-box">

    <h2 class="success">
        Patient Record Found
    </h2>

    <table>

        <tr>
            <th>Patient Details</th>
            <th>Information</th>
        </tr>

        <tr>
            <td>Patient ID</td>

            <td>
                <?php
                echo htmlspecialchars(
                    $patientRecord["id"]
                );
                ?>
            </td>
        </tr>

        <tr>
            <td>Patient Name</td>

            <td>
                <?php
                echo htmlspecialchars(
                    $patientRecord["name"]
                );
                ?>
            </td>
        </tr>

        <tr>
            <td>Age</td>

            <td>
                <?php
                echo htmlspecialchars(
                    $patientRecord["age"]
                );
                ?>
            </td>
        </tr>

        <tr>
            <td>Department</td>

            <td>
                <?php
                echo htmlspecialchars(
                    $patientRecord["department"]
                );
                ?>
            </td>
        </tr>

        <tr>
            <td>Diagnosis</td>

            <td>
                <?php
                echo htmlspecialchars(
                    $patientRecord["diagnosis"]
                );
                ?>
            </td>
        </tr>

    </table>

</div>

<?php

}

?>

<br>

<a href="index.html" class="back">
    Back to Patient Management
</a>

</div>

</body>

</html>