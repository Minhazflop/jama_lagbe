<?php
session_start();
if (isset($_SESSION['user'])) {

    require_once('Connection.php');
    require_once("userclass.php");
    $email = $_GET['email'];
    $query = "SELECT * FROM user WHERE email='$email'";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_array($result);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $name = $_POST['name'];
        $phone = $_POST['phone'];
        $address = $_POST['address'];
        $password = $_POST['password'];

        $passenger = new user();
        $passenger->UpdateUser($email, $name, $phone,  $address, $password, $con);

        header("Location: login.php?email=" . $email);
        exit();
    }

    echo '<form method="POST" action="">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" value="' . $row['name'] . '" required/><br/>
        <label for="phone">Phone:</label>
        <input type="text" id="phone" name="phone" value="' . $row['phone'] . '" required/><br/>
        
        <label for="address">Address:</label>
        <input type="text" id="address" name="address" value="' . $row['address'] . '" required/><br/>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" placeholder="Enter password" required/><br/>
        <input type="submit" value="Update Info"/>
    </form>';

} else {
    header("location:login.php");
}
?>