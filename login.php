<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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

        .login-container {
            background-color: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
            text-align: center;
        }

        .login-container h1 {
            margin-bottom: 30px;
            font-size: 24px;
            color: #333;
        }

        .login-container input[type="text"],
        .login-container input[type="password"] {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        .login-container button {
            background-color: #6c757d;
            color: white;
            border: none;
            padding: 12px;
            width: 100%;
            margin: 10px 0;
            cursor: pointer;
            border-radius: 5px;
            font-size: 16px;
        }

        .login-container button:hover {
            background-color: #5a6268;
        }

        .login-container .link {
            display: block;
            margin-top: 10px;
            color: #007bff;
            text-decoration: none;
        }

        .login-container .link:hover {
            text-decoration: underline;
        }

        .logo {
            margin-bottom: 20px;
        }

        .logo img {
            width: 100px;
        }

        /* Responsive Design */
        @media (max-width: 600px) {
            .login-container {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="logo">
            <img src="logo.png" alt="Company Logo"> <!-- Placeholder for your logo -->
        </div>
        <h1>Login</h1>
        <form action="loginProcess.php" method="post">
            <input type="text" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" name="login">Login</button>
        </form>

        <form action="Signup.php" method="get">
            <button type="submit" name="signup">Sign Up</button>
        </form>

       
    </div>
</body>
</html>
