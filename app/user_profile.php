<?php
session_start();

$mysqli = require __DIR__ . '/../database.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];


$query = "SELECT * FROM users WHERE id = ?";
$stmt = $mysqli->prepare($query);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
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
        .profile-container {
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
        .profile-info {
            display: grid;
            gap: 1rem;
        }
        .info-group {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.5rem 0;
            border-bottom: 1px solid #4a5568;
        }
        .info-label {
            font-weight: bold;
            color: #a0aec0;
        }
        .info-value {
            color: #fff;
        }
        .edit-button {
            background-color: #3182ce;
            color: #fff;
            border: none;
            border-radius: 4px;
            padding: 0.5rem 1rem;
            cursor: pointer;
            font-size: 1rem;
            transition: background-color 0.3s;
            margin-top: 1rem;
        }
        .edit-button:hover {
            background-color: #2c5282;
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
                <li><a href="../index.php">Home</a></li>
                <li><a href="/app/user_profile.php">Profile</a></li>
                <li><a href="/app/cv.php">CV</a></li>
                <li><a href="/app/projects.php">Mes projets</a></li>
                <li><a href="func/logout.php">Déconnexion</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <div class="profile-container">
            <h1>User Profile</h1>
            <div class="profile-info">
                <div class="info-group">
                    <span class="info-label">Name:</span>
                    <span class="info-value"><?php echo htmlspecialchars($user['first_name'] . ' ' . $user['last_name']); ?></span>
                </div>
                <div class="info-group">
                    <span class="info-label">Email:</span>
                    <span class="info-value"><?php echo htmlspecialchars($user['email']); ?></span>
                </div>
                <div class="info-group">
                    <span class="info-label">Role:</span>
                    <span class="info-value"><?php echo htmlspecialchars($user['role']); ?></span>
                </div>
                <div class="info-group">
                    <span class="info-label">Account Created:</span>
                    <span class="info-value"><?php echo htmlspecialchars($user['created_at']); ?></span>
                </div>
            </div>
            <button class="edit-button" onclick="location.href='func/user_profile_edit.php'">Edit Profile</button>
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