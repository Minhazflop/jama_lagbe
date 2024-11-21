<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];

    // Validate email format
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $subject = "Password Reset Request";
        $message = "Click the link below to reset your password:\n\n";
        $message .= "http://yourwebsite.com/resetPassword.php?email=" . urlencode($email);
        
        // Additional headers
        $headers = "From: noreply@yourwebsite.com\r\n";
        $headers .= "Reply-To: noreply@yourwebsite.com\r\n";
        $headers .= "X-Mailer: PHP/" . phpversion();

        // Send the email
        if (mail($email, $subject, $message, $headers)) {
            echo "A password reset email has been sent to your email address.";
        } else {
            echo "Failed to send the password reset email.";
        }
    } else {
        echo "Invalid email address.";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .forgot-container {
            background-color: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
            text-align: center;
        }

        .forgot-container h1 {
            margin-bottom: 20px;
        }

        .forgot-container input[type="text"] {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .forgot-container button {
            background-color: #007bff;
            color: white;
            padding: 12px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            width: 100%;
        }

        .forgot-container button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="forgot-container">
        <h1>Forgot Password</h1>
        <form action="forgotPassword.php" method="post">
            <input type="text" name="email" placeholder="Enter your email" required>
            <button type="submit">Reset Password</button>
        </form>
    </div>
</body>
</html>
