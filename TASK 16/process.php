<?php

session_start();


/*
 * Set timezone
 */

date_default_timezone_set(
    "Asia/Kolkata"
);


$message = "";

$messageType = "";


/*
 * Check form submission
 */

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $customerName =
        trim($_POST["customer_name"]);

    $email =
        trim($_POST["email"]);

    $destination =
        trim($_POST["destination"]);

    $travelDate =
        $_POST["travel_date"];

    $travellers =
        (int) $_POST["travellers"];


    /*
     * Validate input fields
     */

    if (
        empty($customerName) ||
        empty($email) ||
        empty($destination) ||
        empty($travelDate) ||
        $travellers <= 0
    ) {

        $message =
            "Please fill in all required fields correctly.";

        $messageType =
            "error";

    }

    else {

        /*
         * Create date objects
         */

        $selectedDate =
            new DateTime($travelDate);

        $currentDate =
            new DateTime();

        $currentDate->setTime(
            0,
            0,
            0
        );


        /*
         * Check travel date
         */

        if ($selectedDate < $currentDate) {

            $message =
                "Travel date cannot be in the past.";

            $messageType =
                "error";

        }

        else {

            /*
             * Store booking information
             * in session
             */

            $_SESSION["customer_name"] =
                $customerName;

            $_SESSION["destination"] =
                $destination;

            $_SESSION["travel_date"] =
                $travelDate;

            $_SESSION["travellers"] =
                $travellers;


            /*
             * Generate booking ID
             */

            $bookingId =
                "TB" .
                date("YmdHis");


            $_SESSION["booking_id"] =
                $bookingId;


            /*
             * Prepare booking record
             */

            $bookingRecord =
                "----------------------------------------" .
                PHP_EOL .

                "Booking ID: " .
                $bookingId .
                PHP_EOL .

                "Customer Name: " .
                $customerName .
                PHP_EOL .

                "Email: " .
                $email .
                PHP_EOL .

                "Destination: " .
                $destination .
                PHP_EOL .

                "Travel Date: " .
                $selectedDate->format("d-m-Y") .
                PHP_EOL .

                "Number of Travellers: " .
                $travellers .
                PHP_EOL .

                "Booking Date: " .
                date("d-m-Y h:i:s A") .
                PHP_EOL .

                "----------------------------------------" .
                PHP_EOL;


            /*
             * Store booking information
             * in text file
             */

            $fileName =
                "travel_bookings.txt";


            if (
                file_put_contents(
                    $fileName,
                    $bookingRecord,
                    FILE_APPEND
                ) !== false
            ) {

                $message =
                    "Travel booking completed successfully.";

                $messageType =
                    "success";

            }

            else {

                $message =
                    "Unable to store booking information.";

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

    <title>Travel Booking Confirmation</title>

    <link rel="stylesheet"
          href="style.css">

</head>

<body>

<div class="container">

    <h1>Travel Booking Confirmation</h1>


<?php

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
 * Display booking confirmation
 */

if ($messageType == "success") {

?>

<div class="booking-box">

    <h2>Booking Details</h2>


    <p>

        <strong>Booking ID:</strong>

        <?php
        echo htmlspecialchars(
            $_SESSION["booking_id"]
        );
        ?>

    </p>


    <p>

        <strong>Customer Name:</strong>

        <?php
        echo htmlspecialchars(
            $_SESSION["customer_name"]
        );
        ?>

    </p>


    <p>

        <strong>Destination:</strong>

        <?php
        echo htmlspecialchars(
            $_SESSION["destination"]
        );
        ?>

    </p>


    <p>

        <strong>Travel Date:</strong>

        <?php

        echo date(
            "d-m-Y",
            strtotime(
                $_SESSION["travel_date"]
            )
        );

        ?>

    </p>


    <p>

        <strong>Number of Travellers:</strong>

        <?php
        echo $_SESSION["travellers"];
        ?>

    </p>


    <p>

        <strong>Booking Status:</strong>

        Confirmed

    </p>

</div>

<?php

}

?>

<br>

<a href="index.php"
   class="back">

    Book Another Travel

</a>

</div>

</body>

</html>