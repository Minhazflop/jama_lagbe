<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "jama_lagbe"; 

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "<style>
        body {
            font-family: Arial, sans-serif;
            background-color:  #fceae8;
            color: #333;
            text-align: center;
        }
        h2 {
            color: #4CAF50;
        }
        .form {
            max-width: 500px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            border-radius: 8px;
        }
        .input-field {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .btn {
            background-image: linear-gradient(to bottom ,#ff589b 0%, #ff136f 100%);
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .btn:hover {
            background-color: #45a049;
        }
        p {
            font-size: 16px;
        }
    </style>";


    // Check if item_id is passed via GET method
    if (isset($_GET['item_id'])) {
        $item_id = $_GET['item_id'];

        // Fetch the item from the database to confirm it's available
        $sql = "SELECT * FROM ClothingItems WHERE item_id = :item_id AND available_for = 'donation' AND status = 'available'";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':item_id', $item_id, PDO::PARAM_INT);
        $stmt->execute();
        $item = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($item) {
            // Display donee form for taking the donation
            echo "<h2>Donee Information</h2>";
            echo "<form method='POST' action='take_donation.php' class='form'>
                <input type='hidden' name='item_id' value='" . $item_id . "'>
                <label for='buyer_email'>Enter your Email:</label>
                <input type='email' name='buyer_email' class='input-field' required>
                <label for='transaction_type'>Select Transaction Type:</label>
                <select name='transaction_type' class='input-field' required>
                    <option value='donation'>Donation</option>
                    <option value='buy'>Buy</option>
                    <option value='rent'>Rent</option>
                    <option value='borrow'>Borrow</option>
                </select>
                <button type='submit' class='btn'>Confirm Donation</button>
              </form>";
        } else {
            echo "<p>Item not found or already taken.</p>";
        }
    }

    // If form is submitted via POST (donee submits the form)
    else if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['item_id'])) {
        // Process the donation and insert transaction
        $item_id = $_POST['item_id'];
        $buyer_email = $_POST['buyer_email'];
        $transaction_type = $_POST['transaction_type'];

        // Insert transaction into the transaction table
        $sql = "INSERT INTO Transactions (item_id, buyer_email, transaction_type, date) 
                VALUES (:item_id, :buyer_email, :transaction_type, NOW())";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':item_id', $item_id, PDO::PARAM_INT);
        $stmt->bindParam(':buyer_email', $buyer_email, PDO::PARAM_STR);
        $stmt->bindParam(':transaction_type', $transaction_type, PDO::PARAM_STR);
        $stmt->execute();

        // Update the status of the item to 'donated' or 'sold' depending on the transaction type
        if ($transaction_type == 'donation') {
            $sql = "UPDATE ClothingItems SET status = 'donated' WHERE item_id = :item_id";
        } else {
            $sql = "UPDATE ClothingItems SET status = 'sold' WHERE item_id = :item_id";
        }
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':item_id', $item_id, PDO::PARAM_INT);
        $stmt->execute();

        echo "<p>Thank you! The transaction has been recorded.</p>";
    }
} catch (PDOException $e) {
    echo "<p>Error: " . $e->getMessage() . "</p>";
}
?>

