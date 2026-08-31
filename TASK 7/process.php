<?php

session_start();


/*
 * LOGIN USER
 */

if (
    isset($_POST["action"]) &&
    $_POST["action"] == "login"
) {

    $userName =
        trim($_POST["user_name"]);


    if (!empty($userName)) {

        /*
         * Store login status and username
         * in session
         */

        $_SESSION["logged_in"] = true;

        $_SESSION["user_name"] =
            $userName;


        /*
         * Create shopping cart if it
         * does not already exist
         */

        if (!isset($_SESSION["cart"])) {

            $_SESSION["cart"] = array();

        }


        /*
         * Create browsing history if it
         * does not already exist
         */

        if (!isset($_COOKIE["browsing_history"])) {

            setcookie(
                "browsing_history",
                "",
                time() + (30 * 24 * 60 * 60),
                "/"
            );

        }


        /*
         * Store username in cookie
         */

        setcookie(
            "shopping_user",
            $userName,
            time() + (30 * 24 * 60 * 60),
            "/"
        );

    }

}


/*
 * CHECK LOGIN STATUS
 */

if (
    !isset($_SESSION["logged_in"]) ||
    $_SESSION["logged_in"] != true
) {

    header("Location: index.php");

    exit();

}


/*
 * ADD PRODUCT TO CART
 */

if (
    isset($_POST["action"]) &&
    $_POST["action"] == "add_cart"
) {

    $product =
        $_POST["product"];


    $_SESSION["cart"][] =
        $product;

}


/*
 * ADD PRODUCT TO BROWSING HISTORY
 */

if (
    isset($_POST["action"]) &&
    $_POST["action"] == "view_product"
) {

    $product =
        $_POST["product"];


    $history = array();


    if (
        isset($_COOKIE["browsing_history"]) &&
        !empty($_COOKIE["browsing_history"])
    ) {

        $history =
            explode(
                "|",
                $_COOKIE["browsing_history"]
            );

    }


    /*
     * Add selected product to history
     */

    array_unshift(
        $history,
        $product
    );


    /*
     * Remove duplicate products
     */

    $history =
        array_unique($history);


    /*
     * Keep only the latest 5 products
     */

    $history =
        array_slice(
            $history,
            0,
            5
        );


    /*
     * Store updated browsing history
     * in cookie
     */

    setcookie(
        "browsing_history",
        implode("|", $history),
        time() + (30 * 24 * 60 * 60),
        "/"
    );

}


/*
 * GET CURRENT CART
 */

$cart = array();

if (isset($_SESSION["cart"])) {

    $cart =
        $_SESSION["cart"];

}


/*
 * GET BROWSING HISTORY
 */

$history = array();

if (
    isset($_COOKIE["browsing_history"]) &&
    !empty($_COOKIE["browsing_history"])
) {

    $history =
        explode(
            "|",
            $_COOKIE["browsing_history"]
        );

}

?>

<!DOCTYPE html>
<html>

<head>

    <title>Online Shopping Dashboard</title>

    <link rel="stylesheet"
          href="style.css">

</head>

<body>

<div class="container">

    <h1>Online Shopping Dashboard</h1>


    <div class="welcome-box">

        <h2>
            Welcome,
            <?php
            echo htmlspecialchars(
                $_SESSION["user_name"]
            );
            ?>
        </h2>

        <p>
            Login Status: Active
        </p>

    </div>


    <h2>Available Products</h2>


    <table>

        <tr>
            <th>Product</th>
            <th>View</th>
            <th>Add to Cart</th>
        </tr>


<?php

$products = array(
    "Laptop",
    "Mobile Phone",
    "Headphones",
    "Smart Watch"
);


foreach ($products as $product) {

?>

        <tr>

            <td>

                <?php
                echo htmlspecialchars(
                    $product
                );
                ?>

            </td>


            <td>

                <form action="process.php"
                      method="post">

                    <input type="hidden"
                           name="action"
                           value="view_product">

                    <input type="hidden"
                           name="product"
                           value="<?php
                           echo htmlspecialchars(
                               $product
                           );
                           ?>">

                    <input type="submit"
                           value="View">

                </form>

            </td>


            <td>

                <form action="process.php"
                      method="post">

                    <input type="hidden"
                           name="action"
                           value="add_cart">

                    <input type="hidden"
                           name="product"
                           value="<?php
                           echo htmlspecialchars(
                               $product
                           );
                           ?>">

                    <input type="submit"
                           value="Add to Cart">

                </form>

            </td>

        </tr>

<?php

}

?>

    </table>


    <h2>Shopping Cart</h2>


<?php

if (count($cart) > 0) {

?>

    <div class="cart-box">

        <ul>

<?php

foreach ($cart as $item) {

?>

            <li>

                <?php
                echo htmlspecialchars(
                    $item
                );
                ?>

            </li>

<?php

}

?>

        </ul>

    </div>

<?php

}

else {

?>

    <p>
        Your shopping cart is empty.
    </p>

<?php

}

?>


    <h2>Browsing History</h2>


<?php

if (count($history) > 0) {

?>

    <div class="history-box">

        <ol>

<?php

foreach ($history as $item) {

?>

            <li>

                <?php
                echo htmlspecialchars(
                    $item
                );
                ?>

            </li>

<?php

}

?>

        </ol>

    </div>

<?php

}

else {

?>

    <p>
        No products viewed yet.
    </p>

<?php

}

?>


    <a href="logout.php"
       class="logout">

        Logout

    </a>

</div>

</body>

</html>