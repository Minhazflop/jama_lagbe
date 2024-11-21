<?php
// Start the session
session_start();

// Check if the session 'user' is set
if (isset($_SESSION['user'])) {

    // Include the database connection file
    require_once('Connection.php');
    
    // Get the name of the logged-in user from the session
    $name = $_SESSION['user'];
    
    // Get the email from the GET request
    $email = $_GET['email'];
    
    // SQL query to select user details based on email
    $query = "SELECT * FROM User WHERE email='$email'";
    $result = mysqli_query($con, $query);

    if (!$result) {
        die("Error fetching user details: " . mysqli_error($con));
    }

    $row = mysqli_fetch_array($result);

    // SQL query to fetch user transactions with item details
    $transactionQuery = "
    SELECT clothingitems.item_id, clothingitems.title, clothingitems.description, clothingitems.category, 
           clothingitems.conditions, clothingitems.price, Transactions.transaction_type, Transactions.date 
    FROM Transactions
    JOIN clothingitems ON Transactions.item_id = clothingitems.item_id
    WHERE Transactions.buyer_email = '$email'
";
    $transactionResult = mysqli_query($con, $transactionQuery);

    if (!$transactionResult) {
        die("Error fetching transactions: " . mysqli_error($con));
    }

    // Wishlist query
    $wishlistQuery = "
        SELECT clothingitems.title, clothingitems.description, clothingitems.category, 
               clothingitems.price
        FROM wishlist
        JOIN clothingitems ON wishlist.item_id = clothingitems.item_id
        WHERE wishlist.email = '$email'
    ";
    $wishlistResult = mysqli_query($con, $wishlistQuery);

    if (!$wishlistResult) {
        die("Error fetching wishlist: " . mysqli_error($con));
    }
    $name = $_SESSION['user'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome, <?php echo $name; ?></title>
    <style>
        /* Global styling */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        /* Navigation bar */
        .navbar {
            background-image: linear-gradient(to bottom ,#ff589b 0%, #ff136f 100%);
            color: white;
            padding: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar a {
            color: white;
            text-decoration: none;
            margin: 0 15px;
        }

        /* Welcome container styling */
        .welcome-container {
            padding: 20px;
            text-align: center;  
        }

        h1 {
            color: #333;
            text-align: center; /* Center align all h1 elements */
        }

        /* Card layout for transactions */
        .card-container1 {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            padding: 20px;
            background-color: lightcoral;
            
        }
        .card-container2 {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            padding: 20px;
            background-color: green;
        }

        .card {
            background-color: #fceae8;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 300px;
            padding: 20px;
            text-align: left;
        }

        .transaction-type {
            background-color: #007bff;
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
            display: inline-block;
            margin-top: 10px;
        }

        /* Wishlist styling */
        .wishlist-section {
            background-color: #e0f7fa; /* Light blue background for wishlist */
            padding: 20px;
            border-radius: 10px;
        }
    </style>
</head>
<body>

    <!-- Navigation bar -->
    <div class="navbar">
        <div class="navbar-left">
            <a href="index.php">Home</a>
            <a href="UpdateUser.php">Update Profile</a>
            <a href="buy.php">Buy</a>
            <a href="logout.php">Logout</a>
        </div>
        <div class="navbar-right">
            <span>Welcome, <?php echo $name; ?></span>
        </div>
    </div>

    <div class="welcome-container">
        <h1>Your Transactions</h1>
        <p>Here is your All order of jama from jama lagbe </p>
    </div>

    <h1>Your Cart</h1>

<!-- Calculate and display the total price -->
<div class="welcome-container">
    <?php
    $totalPrice = 0; // Initialize total price
    ?>
    <div class="card-container1">
        <?php
        if (mysqli_num_rows($transactionResult) > 0) {
            while ($transactionRow = mysqli_fetch_array($transactionResult)) {
                $totalPrice += $transactionRow['price']; // Add item price to total
                echo "<div class='card'>";
                echo "<h3>" . $transactionRow['title'] . "</h3>";
                echo "<p><strong>Description:</strong> " . $transactionRow['description'] . "</p>";
                echo "<p><strong>Category:</strong> " . $transactionRow['category'] . "</p>";
                echo "<p><strong>Condition:</strong> " . $transactionRow['conditions'] . "</p>";
                echo "<p><strong>Price:</strong> $" . $transactionRow['price'] . "</p>";
                echo "<p><strong>Date:</strong> " . $transactionRow['date'] . "</p>";
                echo "<form action='removeFromCart.php' method='POST'>";
                echo "<input type='hidden' name='item_id' value='" . $transactionRow['item_id'] . "'>";
                echo "<button type='submit' style='background-color: red; color: white; border: none; padding: 10px; cursor: pointer;'>Remove</button>";
                echo "</form>";
                echo "</div>";
            }
            // Display total price
            echo "<div style='text-align: center; margin-top: 20px; font-size: 18px;'>";
            echo "<strong>Total Price: $" . $totalPrice . "</strong>";
            echo "</div>";
        } else {
            echo "<p style='text-align:center;'>You have no transactions yet.</p>";
        }
        ?>
    </div>
</div>


    <!-- Transaction cards -->
    <div class="card-container1">
    <?php
    if (mysqli_num_rows($transactionResult) > 0) {
        while ($transactionRow = mysqli_fetch_array($transactionResult)) {
            echo "<div class='card'>";
            echo "<h3>" . $transactionRow['title'] . "</h3>";
            echo "<p><strong>Description:</strong> " . $transactionRow['description'] . "</p>";
            echo "<p><strong>Category:</strong> " . $transactionRow['category'] . "</p>";
            echo "<p><strong>Condition:</strong> " . $transactionRow['conditions'] . "</p>";
            echo "<p><strong>Price:</strong> $" . $transactionRow['price'] . "</p>";
            echo "<p><strong>Date:</strong> " . $transactionRow['date'] . "</p>";
            echo "<form action='removeFromCart.php' method='POST'>";
            echo "<input type='hidden' name='item_id' value='" . $transactionRow['item_id'] . "'>";
            echo "<button type='submit' style='background-color: red; color: white; border: none; padding: 10px; cursor: pointer;'>Remove</button>";
            echo "</form>";
            echo "</div>";
        }
    } else {
        echo "<p style='text-align:center;'>You have no transactions yet.</p>";
    }
    ?>
</div>

    <div class="wishlist-section">
        <h1>Your Wishlist</h1>
        <div class="card-container2">
            <?php
            if (mysqli_num_rows($wishlistResult) > 0) {
                while ($wishlistRow = mysqli_fetch_array($wishlistResult)) {
                    echo "<div class='card'>";
                    echo "<h3>" . $wishlistRow['title'] . "</h3>";
                    echo "<p><strong>Description:</strong> " . $wishlistRow['description'] . "</p>";
                    echo "<p><strong>Category:</strong> " . $wishlistRow['category'] . "</p>";
                    echo "<p><strong>Price:</strong> $" . $wishlistRow['price'] . "</p>";
                    echo "</div>";
                }
            } else {
                echo "<p style='text-align:center;'>Your wishlist is empty.</p>";
            }
            ?>
        </div>
    </div>

</body>
</html>

<?php
} else {
    // If the session 'user' is not set, redirect to the login page
    header("location:login.php");
    exit();
}
?>
