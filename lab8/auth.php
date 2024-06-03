<?php

session_start();
$conn = '';
require_once 'db_connection.php';
$_SESSION['loggedinA'] = false;
$_SESSION['loggedin'] = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_POST['userType'] === 'user') {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $user_id = 1;
        preg_match('/user(\d+)/', $username, $matches);
        if (isset($matches[1])) {
            $user_id = $matches[1];
        } else {
            $error = "Invalid username or password";
        }

        // Perform database query to retrieve the user's information
        // Replace 'users' with the actual table name and column names
        // Prepare and execute the query using prepared statements to prevent SQL injection
        // Replace $db with the actual database connection object
        $hashedPassword = '';
        $result = '';
        try {
            $sql = "select password from users where user_id = :user_id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':user_id', $user_id);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC); // Fetches the result as an associative array
            $hashedPassword = $result['password'];
            // Further processing of the result
        } catch (Exception $e) {
            // Handle the exception, log the error, or perform appropriate error-handling actions
            echo 'Error: ' . $e->getMessage();
        }

        // Check if the user exists and verify the password
        if (isset($hashedPassword)) {
            if (password_verify($password, $hashedPassword)) {
                // Password is correct, start a new session
                session_regenerate_id();
                $_SESSION['loggedin'] = true;
                $_SESSION['username'] = $username;
                $_SESSION['userid'] = $user_id;
                echo "here    ";
                // Redirect to the user's profile page or any other authorized page
                header('Location: profile.php');
                exit;
            } else {
                // Password is incorrect
                echo "Invalid username or password";
            }
        } else {
            // User does not exist
            echo "User does not exist";
        }

        // Close the prepared statement
        $stmt->close();
    }
    else if ($_POST['userType'] === 'admin') {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $admin_id = 1;
        preg_match('/admin(\d+)/', $username, $matches);
        if (isset($matches[1])) {
            $admin_id = $matches[1];
        } else {
            $error = "Invalid username or password";
        }
        $hashedPassword = '';
        $result = '';
        try {
            $sql = "select password from admins where admin_id = :admin_id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':admin_id', $admin_id);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC); // Fetches the result as an associative array
            $hashedPassword = $result['password'];
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }

        if (isset($hashedPassword)) {
            if (password_verify($password, $hashedPassword)) {
                session_regenerate_id();
                $_SESSION['loggedinA'] = true;
                $_SESSION['username'] = $username;
                $_SESSION['adminid'] = $admin_id;
                echo "here    ";
                header('Location: admin.php');
                exit;
            } else {
                echo "Invalid username or password";
            }
        } else {
            echo "User does not exist";
        }

        $stmt->close();
    }

}
