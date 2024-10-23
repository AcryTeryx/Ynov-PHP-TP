<?php
$mode = isset($_GET['mode']) && $_GET['mode'] === 'signup' ? 'signup' : 'login';
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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo ucfirst($mode); ?> Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #1a202c;
            color: #fff;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .container {
            background-color: #2d3748;
            padding: 2rem;
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }
        h1 {
            text-align: center;
            margin-bottom: 1.5rem;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        input {
            margin-bottom: 1rem;
            padding: 0.5rem;
            border: 1px solid #4a5568;
            background-color: #4a5568;
            color: #fff;
            border-radius: 0.25rem;
        }
        input::placeholder {
            color: #a0aec0;
        }
        button {
            background-color: #3182ce;
            color: #fff;
            padding: 0.5rem;
            border: none;
            border-radius: 0.25rem;
            cursor: pointer;
            font-size: 1rem;
            transition: background-color 0.3s;
        }
        button:hover {
            background-color: #2c5282;
        }
        .error {
            color: #fc8181;
            text-align: center;
            margin-bottom: 1rem;
        }
        .toggle-mode {
            text-align: center;
            margin-top: 1rem;
        }
        .toggle-mode a {
            color: #63b3ed;
            text-decoration: none;
        }
        .toggle-mode a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1><?php echo ucfirst($mode); ?></h1>
        
        <?php if ($is_invalid): ?>
        <p class="error">Invalid Email or Password</p>
        <?php endif; ?>

        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?mode=$mode"); ?>">
            <?php if ($mode === 'signup'): ?>
            <input type="text" name="username" placeholder="Username" required>
            <?php endif; ?>
            
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            
            <?php if ($mode === 'signup'): ?>
            <input type="password" name="confirm_password" placeholder="Confirm Password" required>
            <?php endif; ?>
            
            <button type="submit"><?php echo ucfirst($mode); ?></button>
        </form>
        
        <div class="toggle-mode">
            <?php if ($mode === 'login'): ?>
            <a href="?mode=signup">Need an account? Sign Up</a>
            <?php else: ?>
            <a href="?mode=login">Already have an account? Login</a>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>