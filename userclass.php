<?php


class User {

    public $email,$name,$phone,$address;
    private $password;
    // Function to authenticate user login
    function login($email, $password, $con) {
        $query = "SELECT * FROM user WHERE email='$email' AND password='$password'";
        $result = mysqli_query($con, $query);
        
     // If user exists, set session and redirect to welcome page
        
        if ($row = mysqli_fetch_assoc($result)) { 
            $_SESSION['user'] = $row['name'];
            header("Location: Welcome.php?email=" . $row['email']);
            exit(); 
        } else {
            // If user does not exist, redirect to login page with error
            header("location: login.php?Invalid");
            exit(); 
        }
    }
     // Function to retrieve user name by email
    function getName($email,$con){
        $query = "SELECT * FROM user WHERE email='$email'";
        $result = mysqli_query($con, $query);
        if ($row = mysqli_fetch_assoc($result)) { 
            return $row['name'];

        }

    }
     // Function to create a new user
    function createUser($name,$email,$phone,$address,$password,$con){
        $query =" INSERT INTO user (name,email,phone,address,password)
        VALUES ('$name', '$email', '$phone','$address','$password')";
           // Execute query and redirect to login page on success
        if(mysqli_query($con,$query) == TRUE) {
            //echo "New User regesterd successfully";
            header("location: login.php");
        } else {
            // Display error message if query fails
            echo "Error: " . $query . "<br>" . $con->error;
        }
        

    }
    // Function to update user details
    function updateUser($email, $name,  $phone, $address, $password, $con) {
        $query = "UPDATE user 
                  SET name='$name',  phone='$phone',  address='$address', password='$password' 
                  WHERE email='$email'";
         // Display success message or error message based on query execution
        if (mysqli_query($con, $query) == TRUE) {
            echo "User updated successfully";
        } else {
            // Display error message if query fails
            echo "Error: " . $query . "<br>" . $con->error;
        }
    }
    
}
?>