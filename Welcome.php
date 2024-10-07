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
    $query = "SELECT * FROM user WHERE email='$email'";
    
    // Execute the query
    $result = mysqli_query($con, $query);
    
    // Fetch the result as an associative array
    $row = mysqli_fetch_array($result);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome, <?php echo $name; ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .welcome-container {
            background-color: #fff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            width: 100%;
            text-align: center;
        }

        h1 {
            font-size: 24px;
            color: #333;
            margin-bottom: 20px;
        }

        p {
            font-size: 16px;
            color: #666;
            margin: 10px 0;
        }

        .info {
            background-color: #f8f9fa;
            border: 1px solid #e2e6ea;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .info p {
            margin: 5px 0;
        }

        .actions {
            margin-top: 20px;
        }

        .actions a, .actions button {
            background-color: #6c757d; /* Grey color */
            color: white;
            text-decoration: none;
            padding: 10px 15px;
            border-radius: 5px;
            font-size: 14px;
            border: none;
            cursor: pointer;
            margin: 5px;
            display: inline-block;
        }

        .actions a:hover, .actions button:hover {
            background-color: #5a6268; /* Darker grey on hover */
        }

        button {
            background-color: #6c757d;
        }

        button:hover {
            background-color: #5a6268;
        }
    </style>
</head>
<body>
    <div class="welcome-container">
        <h1>Welcome, <?php echo $name; ?></h1>
        <p>Here are your account details:</p>
        <div class="info">
            <p><strong>Email:</strong> <?php echo $row['email']; ?></p>
            <p><strong>Phone:</strong> <?php echo $row['phone']; ?></p>
        </div>
        <div class="actions">
            <a href="UpdateUser.php?email=<?php echo $row['email']; ?>">Update Info</a>
            <form action="logout.php" method="post" style="display:inline;">
                <button type="submit">Logout</button>
            </form>
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
