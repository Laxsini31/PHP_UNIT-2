<?php

session_start();


/*
 * Initialize registration count
 */

if (!isset($_SESSION["registration_count"])) {

    $_SESSION["registration_count"] = 0;

}

?>

<!DOCTYPE html>
<html>

<head>

    <title>Event Registration and Scheduling System</title>

    <link rel="stylesheet" href="style.css">

</head>

<body>

<div class="container">

    <h1>Event Registration and Scheduling System</h1>

    <p>
        Enter event details and register for the event.
    </p>


    <h2>Event Registration Form</h2>

    <form action="process.php" method="post">

        <label>Participant Name</label>

        <input type="text"
               name="participant_name"
               placeholder="Enter participant name"
               required>


        <label>Email Address</label>

        <input type="email"
               name="email"
               placeholder="Enter email address"
               required>


        <label>Event Name</label>

        <input type="text"
               name="event_name"
               placeholder="Enter event name"
               required>


        <label>Event Date</label>

        <input type="date"
               name="event_date"
               required>


        <label>Event Time</label>

        <input type="time"
               name="event_time"
               required>


        <input type="submit"
               value="Register for Event">

    </form>


    <div class="info-box">

        <h2>Registration Information</h2>

        <p>
            Registrations in this session:
            <strong>

                <?php
                echo $_SESSION["registration_count"];
                ?>

            </strong>
        </p>

    </div>

</div>

</body>

</html>