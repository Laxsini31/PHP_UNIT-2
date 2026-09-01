<?php

$message = "";

$messageType = "";

$guestName = "";

$checkIn = "";

$checkOut = "";

$totalDays = 0;


/*
 * Check whether the form is submitted
 */

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $guestName =
        trim($_POST["guest_name"]);

    $checkIn =
        $_POST["check_in"];

    $checkOut =
        $_POST["check_out"];


    /*
     * Validate input fields
     */

    if (
        empty($guestName) ||
        empty($checkIn) ||
        empty($checkOut)
    ) {

        $message =
            "Please fill in all required fields.";

        $messageType =
            "error";

    }

    else {

        /*
         * Convert dates into DateTime objects
         */

        $checkInDate =
            new DateTime($checkIn);

        $checkOutDate =
            new DateTime($checkOut);


        /*
         * Check whether check-out date
         * is greater than check-in date
         */

        if (
            $checkOutDate <= $checkInDate
        ) {

            $message =
                "Check-out date must be after the check-in date.";

            $messageType =
                "error";

        }

        else {

            /*
             * Calculate date difference
             */

            $difference =
                $checkInDate->diff(
                    $checkOutDate
                );


            /*
             * Get total number of days
             */

            $totalDays =
                $difference->days;


            $message =
                "Stay duration calculated successfully.";

            $messageType =
                "success";

        }

    }

}

?>

<!DOCTYPE html>
<html>

<head>

    <title>Hotel Stay Duration Result</title>

    <link rel="stylesheet"
          href="style.css">

</head>

<body>

<div class="container">

    <h1>Hotel Stay Duration Result</h1>


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
 * Display stay duration
 */

if ($messageType == "success") {

?>

<div class="result-box">

    <h2>Guest Stay Summary</h2>


    <p>

        <strong>Guest Name:</strong>

        <?php
        echo htmlspecialchars(
            $guestName
        );
        ?>

    </p>


    <p>

        <strong>Check-in Date:</strong>

        <?php
        echo date(
            "d-m-Y",
            strtotime($checkIn)
        );
        ?>

    </p>


    <p>

        <strong>Check-out Date:</strong>

        <?php
        echo date(
            "d-m-Y",
            strtotime($checkOut)
        );
        ?>

    </p>


    <p>

        <strong>Total Days Stayed:</strong>

        <?php
        echo $totalDays;
        ?>

        day(s)

    </p>

</div>

<?php

}

?>

<br>

<a href="index.html"
   class="back">

    Calculate Another Stay

</a>

</div>

</body>

</html>