<?php
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "jama_lagbe"; 

// Directory where photos will be saved
$targetDir = "uploads/";

// Initialize message variable
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        // Establish the database connection
        $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Collect form data
        $email = $_POST['email'];
        $title = $_POST['title'];
        $description = $_POST['description'];
        $category = $_POST['category'];
        
        // Handle file upload
        if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
            $fileName = basename($_FILES['photo']['name']);
            $targetFilePath = $targetDir . $fileName;
            $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
            
            // Allow only specific file formats
            $allowedTypes = array('jpg', 'jpeg', 'png', 'gif');
            if (in_array(strtolower($fileType), $allowedTypes)) {
                // Move the file to the specified directory
                if (move_uploaded_file($_FILES['photo']['tmp_name'], $targetFilePath)) {
                    // File uploaded successfully, save the file path to the database
                    $sql = "INSERT INTO ClothingItems (email, title, description, category, `conditions`, price, available_for, status, date_added, photo) 
                            VALUES (:email, :title, :description, :category, 'used', 0.00, 'donation', 'available', NOW(), :photo)";
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindParam(':email', $email);
                    $stmt->bindParam(':title', $title);
                    $stmt->bindParam(':description', $description);
                    $stmt->bindParam(':category', $category);
                    $stmt->bindParam(':photo', $targetFilePath);

                    $stmt->execute();
                    $message = "<p>Donation added successfully with photo.</p>";
                } else {
                    $message = "<p>Sorry, there was an error uploading your file.</p>";
                }
            } else {
                $message = "<p>Only JPG, JPEG, PNG, and GIF files are allowed.</p>";
            }
        } else {
            $message = "<p>Error: " . $_FILES['photo']['error'] . "</p>";
        }
    } catch (PDOException $e) {
        $message = "<p>Error: " . $e->getMessage() . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Donate a Clothing Item</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #fceae8;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background-color: #fff;
            padding: 20px;
            width: 100%;
            max-width: 500px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        h2 {
            text-align: center;
            color: #333;
        }
        p.description {
            text-align: center;
            color: #666;
        }
        label {
            font-weight: bold;
            margin-top: 10px;
        }
        input[type="text"], input[type="email"], textarea, select {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border-radius: 5px;
            border: 1px solid #ddd;
        }
        textarea {
            resize: vertical;
        }
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-image: linear-gradient(to bottom ,#ff589b 0%, #ff136f 100%);
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 20px;
        }
        input[type="submit"]:hover {
            background-color: #218838;
        }
        .message {
            text-align: center;
            margin-bottom: 20px;
            color: green;
        }
        .error {
            color: red;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Display message at the top -->
        <?php if (!empty($message)): ?>
            <div class="message">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <h2>Donate a Clothing Item</h2>
        <p class="description">Contribute to our cause by donating your gently used clothing items. Your donation can make a difference!</p>
        
        <form action="add_donation.php" method="POST" enctype="multipart/form-data">
            <label for="email">Email:</label>
            <input type="email" name="email" required>

            <label for="title">Product Title:</label>
            <input type="text" name="title" required>

            <label for="description">Description:</label>
            <textarea name="description" rows="4" required></textarea>

            <label for="category">Category:</label>
            <input type="text" name="category" required>

            <label for="photo">Upload a Photo:</label>
            <input type="file" name="photo" accept="image/*">

            <input type="submit" value="Donate">
        </form>
    </div>
</body>
</html>
