<?php

$message = "";
$messageType = "";

$shipmentRecords = array();

$shipmentFolder = "shipments";


/*
 * Create the shipments directory
 * if it does not already exist
 */

if (!is_dir($shipmentFolder)) {

    mkdir(
        $shipmentFolder,
        0777,
        true
    );

}


/*
 * ADD SHIPMENT RECORD
 */

if (
    $_SERVER["REQUEST_METHOD"] == "POST" &&
    $_POST["action"] == "add"
) {

    $shipmentId =
        trim($_POST["shipment_id"]);

    $customerName =
        trim($_POST["customer_name"]);

    $destination =
        trim($_POST["destination"]);

    $status =
        trim($_POST["status"]);


    /*
     * Validate all fields
     */

    if (
        empty($shipmentId) ||
        empty($customerName) ||
        empty($destination) ||
        empty($status)
    ) {

        $message =
            "Please fill in all required fields.";

        $messageType = "error";

    }

    else {

        /*
         * Create a separate file
         * for each shipment
         */

        $fileName =
            $shipmentFolder . "/" .
            $shipmentId . ".txt";


        /*
         * Create shipment record
         */

        $record =
            "Shipment ID: " .
            $shipmentId .
            PHP_EOL .

            "Customer Name: " .
            $customerName .
            PHP_EOL .

            "Destination: " .
            $destination .
            PHP_EOL .

            "Shipment Status: " .
            $status .
            PHP_EOL;


        /*
         * Store shipment details
         * in the file
         */

        if (
            file_put_contents(
                $fileName,
                $record
            ) !== false
        ) {

            $message =
                "Shipment record stored successfully.";

            $messageType =
                "success";

        }

        else {

            $message =
                "Unable to store shipment record.";

            $messageType =
                "error";

        }

    }

}


/*
 * SEARCH SHIPMENT RECORD
 */

if (
    $_SERVER["REQUEST_METHOD"] == "POST" &&
    $_POST["action"] == "search"
) {

    $searchId =
        trim($_POST["search_id"]);


    /*
     * Create the file name
     * using shipment ID
     */

    $fileName =
        $shipmentFolder . "/" .
        $searchId . ".txt";


    /*
     * Check whether the file exists
     */

    if (file_exists($fileName)) {

        /*
         * Read shipment details
         */

        $shipmentData =
            file(
                $fileName,
                FILE_IGNORE_NEW_LINES
            );


        foreach (
            $shipmentData
            as $line
        ) {

            $shipmentRecords[] =
                $line;

        }


        $message =
            "Shipment record found successfully.";

        $messageType =
            "success";

    }

    else {

        $message =
            "Shipment record not found.";

        $messageType =
            "error";

    }

}


/*
 * Get all shipment files
 * from the directory
 */

$availableFiles = array();

if (is_dir($shipmentFolder)) {

    $availableFiles =
        scandir($shipmentFolder);


    /*
     * Remove . and .. from
     * directory listing
     */

    $availableFiles =
        array_diff(
            $availableFiles,
            array(".", "..")
        );

}

?>

<!DOCTYPE html>
<html>

<head>

    <title>Shipment Record Result</title>

    <link rel="stylesheet"
          href="style.css">

</head>

<body>

<div class="container">

    <h1>Shipment Record Result</h1>


<?php

/*
 * Display success or error message
 */

if (!empty($message)) {

?>

<div class="<?php

echo $messageType == "success"
    ? "success-box"
    : "error-box";

?>">

    <h2 class="<?php
    echo $messageType;
    ?>">

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


/*
 * Display searched shipment
 * record
 */

if (
    count($shipmentRecords) > 0
) {

?>

<div class="record-box">

    <h2>
        Shipment Details
    </h2>

<?php

foreach (
    $shipmentRecords
    as $record
) {

?>

    <p>

        <?php
        echo htmlspecialchars(
            $record
        );
        ?>

    </p>

<?php

}

?>

</div>

<?php

}


/*
 * Display available shipment files
 */

if (
    count($availableFiles) > 0
) {

?>

<div class="files-box">

    <h2>
        Available Shipment Records
    </h2>

    <table>

        <tr>

            <th>
                File Name
            </th>

        </tr>

<?php

foreach (
    $availableFiles
    as $file
) {

?>

        <tr>

            <td>

                <?php
                echo htmlspecialchars(
                    $file
                );
                ?>

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

<div class="error-box">

    <p>
        No shipment records available.
    </p>

</div>

<?php

}

?>

<br>

<a href="index.html"
   class="back">

    Back to Shipment Management

</a>

</div>

</body>

</html>