<?php
session_start();

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

// Handle form submission for search
$search_query = "";
if (isset($_GET['search'])) {
    $search_query = $_GET['search'];
}


// Handle form submission (after user provides buyer email and transaction type)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['item_id']) && isset($_POST['buyer_email']) && isset($_POST['transaction_type'])) {
    $item_id = $_POST['item_id'];
    $buyer_email = $_POST['buyer_email'];
    $transaction_type = $_POST['transaction_type']; // Capture transaction type
    $current_date = date('Y-m-d H:i:s');

    // Start a transaction to ensure both insert and update happen atomically
    $conn->begin_transaction();

    try {
        // Prepare SQL for transaction insertion
        $sql = "INSERT INTO Transactions (item_id, date, buyer_email, transaction_type) 
                VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);

        // Check if prepare() was successful
        if ($stmt === false) {
            throw new Exception("Prepare failed: " . $conn->error);
        }

        // Bind parameters: item_id (integer), current_date (string), buyer_email (string), transaction_type (string)
        $stmt->bind_param("isss", $item_id, $current_date, $buyer_email, $transaction_type);

        // Execute the statement
        if (!$stmt->execute()) {
            throw new Exception("Execute failed: " . $stmt->error);
        }

        // Prepare and execute the update statement
        $sql_update = "UPDATE ClothingItems SET status = 'sold' WHERE item_id = ?";
        $stmt_update = $conn->prepare($sql_update);

        // Check if prepare() was successful
        if ($stmt_update === false) {
            throw new Exception("Prepare failed: " . $conn->error);
        }

        $stmt_update->bind_param("i", $item_id);

        if (!$stmt_update->execute()) {
            throw new Exception("Execute failed: " . $stmt_update->error);
        }

        // Commit the transaction
        $conn->commit();

        // Display success message and button
        echo "<div class='success-msg'>
                <h3>Transaction successful!</h3>
                <p>Your transaction has been processed and the item has been marked as sold.</p>
                <form action='index.php' method='get'>
                    <button type='submit' class='btn'>Go to Home</button>
                </form>
                <form action='my_cart.php' method='get'>
                    <button type='submit' class='btn'>Mycart</button>
                </form>
                
              </div>";

    } catch (Exception $e) {
        // If an error occurs, rollback the transaction
        $conn->rollback();
        echo "<div class='error-msg'>
                <p>Transaction failed: " . $e->getMessage() . "</p>
              </div>";
    }

    // Close the prepared statements
    if ($stmt !== false) {
        $stmt->close();
    }
    if ($stmt_update !== false) {
        $stmt_update->close();
    }

    // Close the database connection
    if ($conn !== null) {
        $conn->close();
    }



    
    
   


} else if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['item_id'])) {
    // Display buyer information form after clicking 'Buy'
    $item_id = $_POST['item_id'];

    echo "<h2>Buyer Information</h2>";
    echo "<form method='POST' action='buy.php' class='form'>
        <input type='hidden' name='item_id' value='" . $item_id . "'>
        <label for='buyer_email'>Enter your Email:</label>
        <input type='email' name='buyer_email' class='input-field' required>
        <label for='transaction_type'>Select Transaction Type:</label>
        <select name='transaction_type' class='input-field' required>
            <option value='buy'>Buy</option>
            <option value='rent'>Rent</option>
            <option value='borrow'>Borrow</option>
            <option value='donation'>Donation</option>
        </select>
        <button type='submit' class='btn'>Confirm Purchase</button>
      </form>";

} else {
    // Display available products or search results
    $sql = "SELECT item_id, title, description, category, conditions, price, photo 
        FROM ClothingItems 
        WHERE available_for='sale' AND status = 'available'";

    if (!empty($search_query)) {
    $sql .= " AND (title LIKE '%" . $conn->real_escape_string($search_query) . "%' 
                OR category LIKE '%" . $conn->real_escape_string($search_query) . "%')";
     }

    $result = $conn->query($sql);

    echo "<div class='container'>";
    echo "<h2>Available Products</h2>";

    // Search form
    echo "<form method='GET' action='buy.php' class='search-form'>
            <input type='text' name='search' class='search-input' placeholder='Search by title or category' value='" . htmlspecialchars($search_query) . "'>
            <button type='submit' class='btn'>Search</button>
          </form>";
    echo "<div class='product-grid'>";
    if ($result && $result->num_rows > 0) {  // Check if result is valid and has rows
        // Display the products
        while ($row = $result->fetch_assoc()) {
            echo "<div class='product-card'>
                    <h3>" . htmlspecialchars($row['title']) . "</h3>
                    <img src='" . htmlspecialchars($row['photo']) . "' alt='" . htmlspecialchars($row['title']) . "' style='width: 100%; height: auto;'>
                    <p>" . htmlspecialchars($row['description']) . "</p>
                    <p>Category: " . htmlspecialchars($row['category']) . "</p>
                    <p>Condition: " . htmlspecialchars($row['conditions']) . "</p>
                    <p>Price: Tk- " . htmlspecialchars($row['price']) . "</p>
                    <form method='POST' action='buy.php'>
                        <input type='hidden' name='item_id' value='" . $row['item_id'] . "'>
                        <button type='submit' class='btn'>Buy</button>
                    </form>
                     <form method='POST' action='add_to_wishlist.php'>
                       <input type='hidden' name='item_id' value='" . $row['item_id'] . "'>
                    <button type='submit' class='btn'>Add to wishlist</button>
                    </form>

                  </div>";
        }
    } else {
        echo "<p>No items available for purchase.</p>";
    }

    echo "</div>"; // End of container
    echo "</div>";
}


?>

<!-- CSS for better styling -->
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #fceae8; 
        margin: 0;
        padding: 0;
    }
    .container {
        width: 80%;
        margin: 0 auto;
        padding: 20px;
    }
    h2 {
        text-align: center;
        color: #333;
        margin-bottom: 20px;
    }
    .search-form {
        text-align: center;
        margin-bottom: 30px;
    }
    .search-input {
        padding: 10px;
        width: 300px;
        font-size: 16px;
    }
    .product-grid {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-around;
    }
    .product-card {
        background-color: #fff;
        padding: 20px;
        margin: 15px;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        width: calc(33% - 40px);
        text-align: left;
    }
    .product-card h3 {
        font-size: 22px;
        margin-top: 0;
    }
    .product-card p {
        color: #555;
        margin: 8px 0;
    }
    .btn {
        background-image: linear-gradient(to bottom ,#ff589b 0%, #ff136f 100%);
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 16px;
    }
    .btn:hover {
        background-color: #0056b3;
    }
    .form {
        text-align: center;
    }
    .input-field {
        padding: 10px;
        font-size: 16px;
        margin: 10px 0;
        width: 100%;
        max-width: 300px;
    }
    .success-msg {
        color: green;
        font-weight: bold;
        text-align: center;
    }
    .error-msg {
        color: red;
        font-weight: bold;
        text-align: center;
    }
</style>
