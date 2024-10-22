<?php
$is_invalid = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $mysqli = require __DIR__ . "/database.php";
    
    // Prepare the SQL statement to prevent SQL injection
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("s", $_POST["email"]);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result) {
        $user = $result->fetch_assoc();
        
        if ($user) {
            if (password_verify($_POST["password"], $user["password"])) {
                session_start();
                session_regenerate_id();
                $_SESSION["user_id"] = $user["id"];
                header("Location: index.php");
                exit;
            }
        }
    } else {
        echo "Error: " . $mysqli->error;
    }
    
    $is_invalid = true;
}
?>

<!DOCTYPE html>
<html>

<head>
  <title>LogIn Page</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="styles/index.css">
</head>

<body>
  <h1>LogIn Page</h1>

  <?php if ($is_invalid): ?>
  <p>Invalid Email or Password</p>
  <?php endif; ?>

  <form method="post">
    <input autocomplete="off" type="email" placeholder="Email" name="email" id="email" value="<?= htmlspecialchars($_POST["email"] ?? "") ?>">
    <br><br>
    <input autocomplete="off" type="password" placeholder="Password" name="password" id="password">
    <br><br>
    <button>LogIn</button>
  </form>
  
  <a href="signup.php" class="btn">Sign Up</a>
  
</body>
</html>