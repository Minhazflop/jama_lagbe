<?php
// Start the session
session_start();

// If email and item_id are both submitted, process the wishlist addition
if (isset($_POST['email']) && isset($_POST['item_id'])) {
    // Database connection
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "jama_lagbe"; 

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $email = $_POST['email'];
    $item_id = $_POST['item_id'];

    // Prepare SQL to insert the item into the wishlist table
    $sql = "INSERT INTO wishlist (email, item_id) VALUES (?, ?)";

    // Initialize an empty message variable to store success or error message
    $message = "";

    // Use prepared statement to prevent SQL injection
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("si", $email, $item_id);
        if ($stmt->execute()) {
            // Set success message
            $message = "<div class='message success'>Item successfully added to your wishlist!</div>";
        } else {
            // Set error message
            $message = "<div class='message error'>Error: " . $stmt->error . "</div>";
        }
        $stmt->close();
    } else {
        // Set database error message
        $message = "<div class='message error'>Database error: " . $conn->error . "</div>";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add to Wishlist</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            min-height: 100vh;
        }
        .container {
            background-color: #fceae8;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            max-width: 400px;
            width: 100%;
            text-align: center;
        }
        .container h2 {
            color: #333;
            margin-bottom: 20px;
        }
        .container label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
        }
        .container input[type="email"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .container button {
            background-image: linear-gradient(to bottom ,#ff589b 0%, #ff136f 100%);
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        .container button:hover {
            background-color: #218838;
        }
        .message {
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
            width: 100%;
            text-align: center;
        }
        .success {
            background-color: #d4edda;
            color: green;
            border: 1px solid #c3e6cb;
        }
        .error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>
<body>
    <!-- Display the message at the top -->
    <?php
    if (!empty($message)) {
        echo $message;
    }
    ?>

    <div class="container">
        <h2>Add to Wishlist</h2>
        <!-- Ask user for their email -->
        <form method='POST' action='add_to_wishlist.php'>
            <input type='hidden' name='item_id' value='<?php echo isset($_POST['item_id']) ? $_POST['item_id'] : ''; ?>'>
            <label for='email'>Enter your email:</label>
            <input type='email' name='email' placeholder="example@domain.com" required>
            <button type='submit'>Submit</button>
        </form>
    </div>
</body>
</html>
