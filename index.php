<?php
session_start();

$user = null;
$cvs = [];

if (isset($_SESSION["user_id"])) {
    $mysqli = require __DIR__ . "/database.php";
    $user_id = $_SESSION["user_id"];
    
    // Fetch user data
    $sql = "SELECT * FROM users WHERE id = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result) {
        $user = $result->fetch_assoc();
        
        // Fetch user's CVs
        $cv_sql = "SELECT * FROM cvs WHERE user_id = ?";
        $cv_stmt = $mysqli->prepare($cv_sql);
        $cv_stmt->bind_param("i", $user_id);
        $cv_stmt->execute();
        $cv_result = $cv_stmt->get_result();
        $cvs = $cv_result->fetch_all(MYSQLI_ASSOC);
    } else {
        echo "Error: " . $mysqli->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CV Manager</title>
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
            padding: 2rem;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background-color: #2d3748;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 2rem;
        }
        h1 {
            color: #63b3ed;
            text-align: center;
            margin-bottom: 1.5rem;
        }
        .cv-list {
            display: grid;
            gap: 1rem;
        }
        .cv-item {
            background-color: #4a5568;
            border-radius: 4px;
            padding: 1rem;
        }
        .cv-item h2 {
            color: #63b3ed;
            margin-top: 0;
        }
        .button-group {
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin-top: 2rem;
        }
        .button {
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1rem;
            transition: background-color 0.3s;
            text-decoration: none;
            color: #fff;
        }
        .create-button {
            background-color: #3182ce;
        }
        .create-button:hover {
            background-color: #2c5282;
        }
        .login-button {
            background-color: #48bb78;
        }
        .login-button:hover {
            background-color: #38a169;
        }
    </style>
</head>
<body>
    <?php include "header.php"; ?>

    <main>
        <div class="container">
            <h1>CV created</h1>
            <?php if ($user): ?>
                <div class="cv-list">
                    <?php if (count($cvs) > 0): ?>
                        <?php foreach ($cvs as $cv): ?>
                            <div class="cv-item">
                                <h2><?= htmlspecialchars($cv['title']) ?></h2>
                                <p><?= htmlspecialchars($cv['description']) ?></p>
                                <p>Created: <?= htmlspecialchars($cv['created_at']) ?></p>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>No CVs found. Create your first CV!</p>
                    <?php endif; ?>
                </div>
                <div class="button-group">
                    <a href="create_cv.php" class="button create-button">Create New CV</a>
                </div>
            <?php else: ?>
                <p>Please log in to view and manage your CVs.</p>
                <div class="button-group">
                    <a href="login.php" class="button login-button">Log In</a>
                </div>
            <?php endif; ?>
        </div>
    </main>
        <?php if (isset($user) && isset($user['role']) && $user['role'] === 'admin'): ?>
        <div class="button-group">
            <a href="admin.php" class="button create-button">Admin Panel</a>
        </div>
    <?php endif; ?>
    <?php include "footer.php"; ?>
</body>
</html>