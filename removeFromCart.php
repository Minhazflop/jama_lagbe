<?php
// Start the session
session_start();

// Include the database connection file
require_once('Connection.php');

// Check if the session 'user' is set
if (isset($_SESSION['user'])) {
    // Check if 'item_id' is set in the POST request
    if (isset($_POST['item_id'])) {
        $item_id = $_POST['item_id'];

        // Sanitize the item_id to prevent SQL injection
        $item_id = mysqli_real_escape_string($con, $item_id);

        // Update the status of the item to 'available'
        $updateQuery = "UPDATE clothingitems SET status = 'available' WHERE item_id = '$item_id'";
        if (mysqli_query($con, $updateQuery)) {
            // Remove the item from the Transactions table
            $deleteQuery = "DELETE FROM Transactions WHERE item_id = '$item_id'";
            if (mysqli_query($con, $deleteQuery)) {
                // Redirect back to the welcome page
                header("Location: Welcome.php");
                exit();
            } else {
                die("Error removing item from Transactions: " . mysqli_error($con));
            }
        } else {
            die("Error updating item status: " . mysqli_error($con));
        }
    } else {
        echo "Invalid request: item_id not set.";
    }
} else {
    // If the session 'user' is not set, redirect to the login page
    header("Location: login.php");
    exit();
}
?>
