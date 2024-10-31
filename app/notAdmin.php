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
    <title>No Admin permissions</title>
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
        h1 {
            color: #63b3ed;
            text-align: center;
            margin-bottom: 1.5rem;
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
<h1>You are not an admin</h1>

<main>

    <div>
        <button class="edit-button" onclick="location.href='/../index.php'">Go back to main page</button>
    </div>
</main>
</body>
</html>