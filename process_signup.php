<?php
// Include the database connection file
$mysqli = require __DIR__ . '/database.php';

// Get form data
$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];

// Validate form data
if (empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
    die("All fields are required.");
}

if ($password !== $confirm_password) {
    die("Passwords do not match.");
}

// Hash the password
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Insert user into database
$sql = "INSERT INTO users (email, first_name, last_name, password, role) VALUES (?, ?, ?, ?, 'user')";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("ssss", $email, $username, $username, $hashed_password);

if ($stmt->execute()) {
    header("Location: signup_success.php");
    exit();
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$mysqli->close();
?>