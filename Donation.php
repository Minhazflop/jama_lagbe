<?php
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "jama_lagbe"; 

try {
    // Establish the database connection
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Prepare SQL to fetch items for donation
    $sql = "SELECT item_id, title, description, email, photo FROM ClothingItems WHERE available_for = 'donation' AND status = 'available'";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    // Fetch the result set
    $items = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "<p>Error: " . $e->getMessage() . "</p>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Available Donations</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #fceae8;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            padding: 20px;
        }
        h2 {
            color: #333;
        }
        .item-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            width: 100%;
            max-width: 1200px;
        }
        .item {
            background-color: #fff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .item img {
            width: 100%;
            max-width: 200px;
            height: auto;
            border-radius: 8px;
        }
        .item h3 {
            color: #ff136f;
            margin-bottom: 10px;
        }
        .item p {
            color: #666;
        }
        .item .email {
            margin-top: 10px;
            font-weight: bold;
            color: #333;
        }
        .take-donation-btn {
            margin-top: 15px;
            padding: 10px 20px;
            background-color: #ff136f;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .take-donation-btn:hover {
            background-color: #e0125b;
        }
    </style>
</head>
<body>

    <h2>Available Clothing Donations</h2>

    <div class="item-container">
        <?php if (!empty($items)): ?>
            <?php foreach ($items as $item): ?>
                <div class="item">
                    <img src="<?php echo htmlspecialchars($item['photo']); ?>" alt="Item Photo">
                    <h3><?php echo htmlspecialchars($item['title']); ?></h3>
                    <p><?php echo htmlspecialchars($item['description']); ?></p>
                    <p class="email">Donor Email: <?php echo htmlspecialchars($item['email']); ?></p>
                    <!-- Button to take donation -->
                    <form method="GET" action="take_donation.php">
                        <input type="hidden" name="item_id" value="<?php echo $item['item_id']; ?>">
                        <button type="submit" class="take-donation-btn">Take Donation</button>
                    </form>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No clothing donations are currently available.</p>
        <?php endif; ?>
    </div>

</body>
</html>
