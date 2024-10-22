<?php

session_start();

$user = null;

if (isset($_SESSION["user_id"])) {
    $mysqli = require __DIR__ . "/database.php";
    $user_id = $_SESSION["user_id"];
    

    $sql = "SELECT * FROM users WHERE id = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result) {
        $user = $result->fetch_assoc();
    } else {
        echo "Error: " . $mysqli->error;
    }
}
?>

<!DOCTYPE html>
<html>

<head>
  <title>Connected</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
  <?php include "header.php"; ?>
  <?php include "footer.php"; ?>
</body>
</html>