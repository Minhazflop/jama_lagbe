<?php
// Start session and establish database connection
session_start();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
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

        .signup-container {
            background-color: #fff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            width: 100%;
        }

        .header h1 {
            margin-bottom: 10px;
            font-size: 24px;
            color: #333;
            text-align: center;
        }

        .header p {
            font-size: 16px;
            color: #777;
            text-align: center;
            margin-bottom: 30px;
        }

        .formGroup {
            margin-bottom: 15px;
        }

        .formGroup label {
            display: block;
            margin-bottom: 5px;
            color: #333;
            font-size: 14px;
        }

        .formGroup input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        .formGroup input[type="text"],
        .formGroup input[type="password"],
        .formGroup input[type="int"] {
            font-size: 14px;
        }

        .submitBtn {
            background-color: #6c757d;
            color: white;
            border: none;
            padding: 12px;
            width: 100%;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .submitBtn:hover {
            background-color: #5a6268;
        }

        .alert-light {
            color: red;
            font-size: 14px;
            margin-bottom: 10px;
            text-align: center;
        }
		.logo {
            margin-bottom: 20px;
			text-align: center;
        }

        .logo img {
            width: 100px;
			text-align: center;
        }

        /* Responsive Design */
        @media (max-width: 600px) {
            .signup-container {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
	
    <div class="signup-container">
        <div class="header">
			<div class="logo">
				<img src="logo.png" alt="Company logo">
			</div>
            <h1>Sign Up</h1>
            <p>Create a new profile</p>
        </div>

        <?php
            if (@$_GET['Empty'] == true) {
        ?>
            <div class="alert-light text-danger"><?php echo $_GET['Empty'] ?></div>
        <?php
            }
        ?>
        <?php
            if (@$_GET['UsernameExists'] == true) {
        ?>
            <div class="alert-light text-danger"><?php echo $_GET['UsernameExists'] ?></div>
        <?php
            }
        ?>

        <form action="accountCreate.php" method="POST">
            <div class="formGroup">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="formGroup">
                <label for="email">Email</label>
                <input type="text" id="email" name="email" required>
            </div>
            <div class="formGroup">
                <label for="phone">Mobile No.</label>
                <input type="int" id="phone" name="phone" required>
            </div>
            <div class="formGroup">
                <label for="address">Address</label>
                <input type="text" id="address" name="address" required>
            </div>
            <div class="formGroup">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" class="submitBtn">Register</button>
        </form>
    </div>
</body>
</html>
