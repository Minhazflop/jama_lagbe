<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "jama_lagbe"; // Replace with your actual DB name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $email = $_POST['email'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $category = $_POST['category'];
    $conditions = $_POST['conditions'];
    $price = $_POST['price'];
    $available_for = $_POST['available_for'];
    $status = 'available';  // New products are always 'available' when added

    // Handle file upload
    $targetDir = "uploads/"; // Directory where files will be uploaded
    $photoPath = ''; // Initialize variable for photo path

    // Check if a file was uploaded
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
        $fileName = basename($_FILES['photo']['name']);
        $targetFilePath = $targetDir . $fileName;
        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

        // Allow only specific file formats
        $allowedTypes = array('jpg', 'jpeg', 'png', 'gif');
        if (in_array(strtolower($fileType), $allowedTypes)) {
            // Move the file to the uploads directory
            if (move_uploaded_file($_FILES['photo']['tmp_name'], $targetFilePath)) {
                $photoPath = $targetFilePath; // Store the file path for database insertion
            } else {
                $message = "Sorry, there was an error uploading your file.";
            }
        } else {
            $message = "Only JPG, JPEG, PNG, and GIF files are allowed.";
        }
    } else {
        $message = "Error uploading file.";
    }

    // Insert into ClothingItems table
    if ($photoPath) { // Only proceed if the photo was successfully uploaded
        $sql = "INSERT INTO ClothingItems (email, title, description, category, conditions, price, available_for, status, date_added, photo)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW(), ?)";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sssssdsss', $email, $title, $description, $category, $conditions, $price, $available_for, $status, $photoPath);
        
        if ($stmt->execute()) {
            $message = "Product added successfully!";
        } else {
            $message = "Error: " . $conn->error;
        }

        $stmt->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        .form-container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #fceae8; 
        }

        .form-container h2 {
            margin-top: 0;
        }

        .form-container label {
            display: block;
            margin: 10px 0 5px;
        }

        .form-container input, .form-container select, .form-container textarea {
            width: 100%;
            padding: 8px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .form-container button {
            display: inline-block;
            padding: 10px 15px;
            background-image: linear-gradient(to bottom ,#ff589b 0%, #ff136f 100%);
            color: white;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            cursor: pointer;
        }

        .form-container button:hover {
            background-color: #218838;
        }

        .message {
            padding: 10px;
            margin: 10px 0;
            color: green;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Add a New Product</h2>

        <!-- Display the success or error message -->
        <?php if (isset($message)) { ?>
            <div class="message"><?php echo $message; ?></div>
        <?php } ?>

        <form action="add_product.php" method="POST" enctype="multipart/form-data"> <!-- Added enctype -->
            <label for="email">Your Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="title">Product Title:</label>
            <input type="text" id="title" name="title" required>

            <label for="description">Description:</label>
            <textarea id="description" name="description" rows="5" required></textarea>

            <label for="category">Category:</label>
            <input type="text" id="category" name="category" required>

            <label for="conditions">Condition:</label>
            <input type="text" id="conditions" name="conditions" required>

            <label for="price">Price (BDT):</label>
            <input type="number" id="price" name="price" step="0.01" required>

            <label for="available_for">Available For:</label>
            <select id="available_for" name="available_for" required>
                <option value="sale">Sale</option>
                <option value="rent">Rent</option>
                <option value="donation">Donation</option>
            </select>

            <label for="photo">Upload Photo:</label> <!-- New label for photo upload -->
            <input type="file" id="photo" name="photo" accept="image/*" required>

            <button type="submit">Add Product</button>
            <button type="submit"><a href="index.php">Back</a></button>
        </form>
    </div>
</body>
</html>

