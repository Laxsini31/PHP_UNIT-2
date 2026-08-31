<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = trim($_POST["name"]);

    $category = $_POST["category"];


    if (empty($name) || empty($category)) {

        $error = "Please enter all required details.";

    } else {

        // Store customer preferences in cookies

        setcookie(
            "customer_name",
            $name,
            time() + (86400 * 30)
        );

        setcookie(
            "favorite_category",
            $category,
            time() + (86400 * 30)
        );


        // Track customer visits

        if (isset($_COOKIE["visit_count"])) {

            $visitCount =
                $_COOKIE["visit_count"] + 1;

        } else {

            $visitCount = 1;

        }


        // Store updated visit count

        setcookie(
            "visit_count",
            $visitCount,
            time() + (86400 * 30)
        );

    }

}

?>

<!DOCTYPE html>
<html>
<head>

    <title>Customer Visit Details</title>

    <link rel="stylesheet"
          href="style.css">

</head>

<body>

<div class="container">

<h1>Customer Visit Details</h1>

<?php

if (isset($error)) {

?>

<div class="error-box">

    <h2 class="error">
        Error!
    </h2>

    <p>
        <?php
        echo htmlspecialchars($error);
        ?>
    </p>

</div>

<?php

}

else {

?>

<div class="success-box">

    <h2 class="success">
        Welcome, <?php echo htmlspecialchars($name); ?>!
    </h2>

    <?php

    if ($visitCount == 1) {

    ?>

    <p>
        This is your first visit to our website.
        Your preferences have been saved successfully.
    </p>

    <?php

    }

    else {

    ?>

    <p>
        Welcome back! This is your
        <strong>
            <?php echo $visitCount; ?> visit
        </strong>
        to our website.
    </p>

    <?php

    }

    ?>

    <table>

        <tr>
            <th>Customer Details</th>
            <th>Information</th>
        </tr>

        <tr>
            <td>Customer Name</td>
            <td>
                <?php
                echo htmlspecialchars($name);
                ?>
            </td>
        </tr>

        <tr>
            <td>Favorite Category</td>
            <td>
                <?php
                echo htmlspecialchars($category);
                ?>
            </td>
        </tr>

        <tr>
            <td>Visit Count</td>
            <td>
                <?php
                echo $visitCount;
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
    Update Preferences
</a>

</div>

</body>
</html>