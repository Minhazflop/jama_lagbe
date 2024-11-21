<?php
session_start();
include 'userclass.php'; // Include your User class

// Assuming you have a database connection $con
include 'connection.php';

$user = new User();
$currentEmail = $_SESSION['user']; // Get the logged-in user's email
$name = $user->getName($currentEmail, $con);

// Update logic
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    if ($user->updateUser($currentEmail, $name, $phone, $address, $con)) {
        echo "<p>Information updated successfully!</p>";
    } else {
        // Add this line to display the actual error from the database
        echo "<p>Failed to update information. Error: " . mysqli_error($con) . "</p>";
    }
    
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css"> <!-- Link to your CSS file -->
    <title>Update User Information</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #fceae8; 
            margin: 0;
            padding: 20px;
        }

        h2 {
            color: #333;
        }

        form {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #fceae8; 
    
        }

        input[type="text"],
        input[type="email"],
        input[type="phone"],
        textarea {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="submit"] {
            background-image: linear-gradient(to bottom ,#ff589b 0%, #ff136f 100%);
            color: #fff;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background: #4cae4c;
        }
    </style>
</head>
<body>

<h2>Update Your Information</h2>
<form method="post">
    <label for="name">Name:</label>
    <input type="text" id="name" name="name" value="<?php echo $name; ?>" required>

    <label for="phone">Phone:</label>
    <input type="text" id="phone" name="phone" required>

    <label for="address">Address:</label>
    <textarea id="address" name="address" required></textarea>

    <input type="submit" value="Update">
</form>

</body>
</html>
