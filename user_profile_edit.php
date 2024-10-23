<?php
session_start();

// Include database connection
$mysqli = require __DIR__ . '/database.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch user information
$query = "SELECT * FROM users WHERE id = ?";
$stmt = $mysqli->prepare($query);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

$error_message = '';
$success_message = '';

// Handle form submission for profile update
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['update_profile'])) {
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $email = trim($_POST['email']);
    $new_password = trim($_POST['new_password']);
    $confirm_password = trim($_POST['confirm_password']);

    // Basic validation
    if (empty($first_name) || empty($last_name) || empty($email)) {
        $error_message = "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = "Invalid email format.";
    } elseif (!empty($new_password) && $new_password !== $confirm_password) {
        $error_message = "Passwords do not match.";
    } else {
        // Update user information
        $update_query = "UPDATE users SET first_name = ?, last_name = ?, email = ? WHERE id = ?";
        $update_stmt = $mysqli->prepare($update_query);
        $update_stmt->bind_param('sssi', $first_name, $last_name, $email, $user_id);
        
        if ($update_stmt->execute()) {
            $success_message = "Profile updated successfully.";
            
            // Update password if provided
            if (!empty($new_password)) {
                $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                $password_query = "UPDATE users SET password = ? WHERE id = ?";
                $password_stmt = $mysqli->prepare($password_query);
                $password_stmt->bind_param('si', $hashed_password, $user_id);
                $password_stmt->execute();
            }
            
            // Refresh user data
            $stmt->execute();
            $result = $stmt->get_result();
            $user = $result->fetch_assoc();
        } else {
            $error_message = "Error updating profile. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User Profile</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #1a202c;
            color: #e2e8f0;
            margin: 0;
            padding: 0;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        header {
            background-color: #2f4f6f;
            padding: 20px 0;
        }
        nav ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
        }
        nav ul li {
            margin: 0 25px;
        }
        nav ul li a {
            color: white;
            text-decoration: none;
            font-size: 18px;
            font-weight: bold;
            transition: color 0.3s ease;
        }
        nav ul li a:hover {
            color: #ff6347;
        }
        main {
            flex-grow: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 2rem;
        }
        .edit-profile-container {
            background-color: #2d3748;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 2rem;
            width: 100%;
            max-width: 500px;
        }
        h1 {
            color: #63b3ed;
            text-align: center;
            margin-bottom: 1.5rem;
        }
        form {
            display: grid;
            gap: 1rem;
        }
        label {
            font-weight: bold;
            color: #a0aec0;
        }
        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 0.5rem;
            border: 1px solid #4a5568;
            border-radius: 4px;
            background-color: #2d3748;
            color: #fff;
        }
        .button-group {
            display: flex;
            justify-content: space-between;
            margin-top: 1rem;
        }
        .button {
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1rem;
            transition: background-color 0.3s;
        }
        .update-button {
            background-color: #3182ce;
            color: #fff;
        }
        .update-button:hover {
            background-color: #2c5282;
        }
        .cancel-button {
            background-color: #e53e3e;
            color: #fff;
        }
        .cancel-button:hover {
            background-color: #c53030;
        }
        .message {
            text-align: center;
            margin-bottom: 1rem;
            padding: 0.5rem;
            border-radius: 4px;
        }
        .error {
            background-color: #fc8181;
            color: #742a2a;
        }
        .success {
            background-color: #68d391;
            color: #22543d;
        }
        footer {
            background-color: #2f4f6f;
            padding: 20px;
            text-align: center;
        }
        footer p {
            margin: 10px 0;
            color: #e2e8f0;
        }
        footer a {
            color: #63b3ed;
            text-decoration: none;
            margin: 0 10px;
        }
        footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="user_profile.php">Profile</a></li>
                <li><a href="cv.php">CV</a></li>
                <li><a href="projects.php">Mes projets</a></li>
                <li><a href="logout.php">Déconnexion</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <div class="edit-profile-container">
            <h1>Edit User Profile</h1>
            <?php if (!empty($error_message)): ?>
                <div class="message error"><?php echo $error_message; ?></div>
            <?php endif; ?>
            <?php if (!empty($success_message)): ?>
                <div class="message success"><?php echo $success_message; ?></div>
            <?php endif; ?>
            <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <label for="first_name">First Name:</label>
                <input type="text" id="first_name" name="first_name" value="<?php echo htmlspecialchars($user['first_name']); ?>" required>

                <label for="last_name">Last Name:</label>
                <input type="text" id="last_name" name="last_name" value="<?php echo htmlspecialchars($user['last_name']); ?>" required>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>

                <label for="new_password">New Password (leave blank to keep current):</label>
                <input type="password" id="new_password" name="new_password">

                <label for="confirm_password">Confirm New Password:</label>
                <input type="password" id="confirm_password" name="confirm_password">

                <div class="button-group">
                    <button type="submit" name="update_profile" class="button update-button">Update Profile</button>
                    <a href="user_profile.php" class="button cancel-button">Cancel</a>
                </div>
            </form>
        </div>
    </main>

    <footer>
        <div>
            <p>&copy; <?php echo date("Y"); ?> Ynov-CV web</p>
            <p>
            <a href="https://github.com/AcryTeryx/Ynov-PHP-TP">Project's GitHub</a> | 
                    <a href="https://www.youtube.com/watch?v=dQw4w9WgXcQ">Sponsor of the site </a> | 
                    <a href="https://discord.gg/dUGSC27329">Contact Me on Discord</a>
            </p>
        </div>
    </footer>
</body>
</html>