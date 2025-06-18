<?php 
session_start(); 
require('dbconnect_.php'); 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!empty($_POST['username']) && !empty($_POST['password'])) {
        $email = $_POST['username'];
        $password = $_POST['password'];

        // Prepare and execute the query
        $query = "SELECT * FROM users WHERE email = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if user exists and verify password
        if ($result && $result->num_rows === 1) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password_hash'])) {
                
                $_SESSION['user_id'] = $user['id'];

                 header("Location: index.html");
                exit();
            } else {
                echo "Incorrect password.";
            }
        } else {
            echo "No user found with that email.";
        }

        $stmt->close();
    } else { 
        echo "Please provide both email and password.";
    }
}
?>
