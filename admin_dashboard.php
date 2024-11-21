<?php
// Start session and check if admin is logged in
session_start();
if (!isset($_SESSION['admin_email'])) {
    header("Location: admin_login.php");
    exit;
}

// Include database connection file
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

// Handle deletion of ClothingItems
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $delete_query = "DELETE FROM ClothingItems WHERE item_id = '$delete_id'";
    if (mysqli_query($conn, $delete_query)) {
        $message = "Item deleted successfully.";
    } else {
        $message = "Failed to delete item.";
    }
}

// Handle search query for ClothingItems
$search_term = "";
if (isset($_POST['search_clothing'])) {
    $search_term = mysqli_real_escape_string($conn, $_POST['search_clothing']);
    $clothing_items_query = "SELECT * FROM ClothingItems WHERE title LIKE '%$search_term%' OR category LIKE '%$search_term%'";
} else {
    $clothing_items_query = "SELECT * FROM ClothingItems";
}
$clothing_items_result = mysqli_query($conn, $clothing_items_query);

// Handle search query for Transactions
$search_transaction = "";
if (isset($_POST['search_transaction'])) {
    $search_transaction = mysqli_real_escape_string($conn, $_POST['search_transaction']);
    $transactions_query = "
        SELECT 
            Transactions.transaction_id, 
            Transactions.item_id, 
            Transactions.buyer_email, 
            Transactions.transaction_type, 
            Transactions.date ,
            ClothingItems.title,
            ClothingItems.email AS seller_email,
            ClothingItems.conditions,
            ClothingItems.price
        FROM Transactions
        JOIN ClothingItems ON Transactions.item_id = ClothingItems.item_id
        WHERE Transactions.buyer_email LIKE '%$search_transaction%' 
            OR ClothingItems.title LIKE '%$search_transaction%' 
            OR Transactions.transaction_type LIKE '%$search_transaction%'";
} else {
    $transactions_query = "
        SELECT 
            Transactions.transaction_id, 
            Transactions.item_id, 
            Transactions.buyer_email, 
            Transactions.transaction_type, 
            Transactions.date ,
            ClothingItems.title,
            ClothingItems.email AS seller_email,
            ClothingItems.conditions,
            ClothingItems.price
        FROM Transactions
        JOIN ClothingItems ON Transactions.item_id = ClothingItems.item_id";
}
$transactions_result = mysqli_query($conn, $transactions_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #fceae8;
        }
        .container {
            width: 90%;
            margin: 20px auto;
            max-width: 1000px;
        }
        h2 {
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: salmon;
            color: white;
        }
        .delete-btn {
            background-color: cyan;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            border-radius: 5px;
        }
        .delete-btn:hover {
            background-color: red;
        }
        .message {
            color: green;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .logout-btn {
            display: inline-block; 
            background-color: #3498db; 
            color: white; 
            border: none; 
            padding: 10px 15px; 
            cursor: pointer; 
            border-radius: 5px; 
            text-decoration: none; 
            transition: background-color 0.3s; 
            float: right; 
            margin: 20px 0; 
        }
        .logout-btn:hover {
            background-color: #2980b9; 
        }
        .search-bar {
            margin-bottom: 20px;
        }
        .search-bar input[type="text"] {
            padding: 8px;
            width: 80%;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .search-bar button {
            padding: 8px 15px;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .search-bar button:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Welcome, Admin</h2>
        <a href="logout.php" class="logout-btn">Logout</a>
        
        <?php if (isset($message)): ?>
            <p class="message"><?php echo $message; ?></p>
        <?php endif; ?>

        <div class="search-bar">
            <form method="POST">
                <input type="text" name="search_clothing" placeholder="Search Clothing Items (Title/Category)" value="<?php echo $search_term; ?>">
                <button type="submit">Search</button>
            </form>
        </div>

        <h3>Clothing Items</h3>
        <table>
            <tr>
                <th>Item ID</th>
                <th>Title</th>
                <th>Category</th>
                <th>Condition</th>
                <th>Price</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            <?php while ($item = mysqli_fetch_assoc($clothing_items_result)): ?>
                <tr>
                    <td><?php echo $item['item_id']; ?></td>
                    <td><?php echo $item['title']; ?></td>
                    <td><?php echo $item['category']; ?></td>
                    <td><?php echo $item['conditions']; ?></td>
                    <td><?php echo $item['price']; ?></td>
                    <td><?php echo $item['status']; ?></td>
                    <td>
                        <a href="admin_dashboard.php?delete_id=<?php echo $item['item_id']; ?>" class="delete-btn" onclick="return confirm('Are you sure you want to delete this item?')">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>

        <div class="search-bar">
            <form method="POST">
                <input type="text" name="search_transaction" placeholder="Search Transactions (Buyer/Seller/Transaction Type)" value="<?php echo $search_transaction; ?>">
                <button type="submit">Search</button>
            </form>
        </div>

        <h3>Transactions</h3>
        <table>
            <tr>
                <th>Transaction ID</th>
                <th>Item ID</th>
                <th>Title</th>
                <th>Seller Email</th>
                <th>Condition</th>
                <th>Price</th>
                <th>Buyer Email</th>
                <th>Transaction Type</th>
                <th>Date</th>
            </tr>
            <?php while ($transaction = mysqli_fetch_assoc($transactions_result)): ?>
                <tr>
                    <td><?php echo $transaction['transaction_id']; ?></td>
                    <td><?php echo $transaction['item_id']; ?></td>
                    <td><?php echo $transaction['title']; ?></td>
                    <td><?php echo $transaction['seller_email']; ?></td>
                    <td><?php echo $transaction['conditions']; ?></td>
                    <td><?php echo $transaction['price']; ?></td>
                    <td><?php echo $transaction['buyer_email']; ?></td>
                    <td><?php echo $transaction['transaction_type']; ?></td>
                    <td><?php echo $transaction['date']; ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>
</body>
</html>
