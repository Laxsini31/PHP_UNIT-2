<?php

session_start();

?>

<!DOCTYPE html>
<html>

<head>

    <title>Student Activity Report System</title>

    <link rel="stylesheet" href="style.css">

</head>

<body>

<div class="container">

    <h1>Student Activity Report System</h1>

    <p>
        Enter student activity details to store
        and generate an activity summary.
    </p>


    <h2>Add Student Activity</h2>

    <form action="process.php"
          method="post">

        <input type="hidden"
               name="action"
               value="add">

        <label>Student ID</label>

        <input type="text"
               name="student_id"
               placeholder="Enter student ID"
               required>


        <label>Student Name</label>

        <input type="text"
               name="student_name"
               placeholder="Enter student name"
               required>


        <label>Activity Name</label>

        <input type="text"
               name="activity_name"
               placeholder="Enter activity name"
               required>


        <label>Activity Date</label>

        <input type="date"
               name="activity_date"
               required>


        <input type="submit"
               value="Add Activity">

    </form>


    <h2>Generate Activity Report</h2>

    <form action="process.php"
          method="post">

        <input type="hidden"
               name="action"
               value="report">

        <label>Student ID</label>

        <input type="text"
               name="search_id"
               placeholder="Enter student ID"
               required>


        <input type="submit"
               value="Generate Report">

    </form>

</div>

</body>

</html>