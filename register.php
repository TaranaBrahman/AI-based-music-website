<?php
session_start();
require('dbconnect_.php'); 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $check_email = "SELECT email FROM users WHERE email = ?";
    $stmt_check = $conn->prepare($check_email);
    $stmt_check->bind_param("s", $email);
    $stmt_check->execute();
    $stmt_check->store_result();

    if ($stmt_check->num_rows > 0) {
        echo "Error: Email already exists!";
    } else {
        $query = "INSERT INTO users (email, username, password_hash) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sss", $email, $username, $hashed_password);

        if ($stmt->execute()) {
            // Redirect to inde.html with login form active (default)
            header("Location: login.html?registered=success");
            exit();
        } else {
            echo "Registration failed: " . $stmt->error;
        }
    }
    $stmt_check->close();
}
$conn->close();
?>
