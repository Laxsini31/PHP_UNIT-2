<?php

session_start();

?>

<!DOCTYPE html>
<html>

<head>

    <title>Travel Booking Management System</title>

    <link rel="stylesheet" href="style.css">

</head>

<body>

<div class="container">

    <h1>Travel Booking Management System</h1>

    <p>
        Enter customer and travel details
        to book your journey.
    </p>


    <h2>Travel Booking Form</h2>

    <form action="process.php" method="post">

        <label>Customer Name</label>

        <input type="text"
               name="customer_name"
               placeholder="Enter customer name"
               required>


        <label>Email Address</label>

        <input type="email"
               name="email"
               placeholder="Enter email address"
               required>


        <label>Destination</label>

        <select name="destination" required>

            <option value="">
                Select Destination
            </option>

            <option value="Chennai">
                Chennai
            </option>

            <option value="Bangalore">
                Bangalore
            </option>

            <option value="Hyderabad">
                Hyderabad
            </option>

            <option value="Kochi">
                Kochi
            </option>

            <option value="Mumbai">
                Mumbai
            </option>

        </select>


        <label>Travel Date</label>

        <input type="date"
               name="travel_date"
               required>


        <label>Number of Travellers</label>

        <input type="number"
               name="travellers"
               min="1"
               placeholder="Enter number of travellers"
               required>


        <input type="submit"
               value="Book Travel">

    </form>

</div>

</body>

</html>