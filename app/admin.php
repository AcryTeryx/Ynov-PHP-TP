<?php
session_start();
$mysqli = require __DIR__ . '/../database.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: /login.php');
    exit();
}

// Fetch user data from the database
$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM users WHERE id = ?";
$stmt = $mysqli->prepare($query);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Include the function and check the user's role
include __DIR__ . '/func/checkAdminRole.php';
checkAdminRole($user);

// Handle project approval
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['approve'])) {
    $project_id = $_POST['project_id'];
    $query = "UPDATE projects SET is_validated = 1 WHERE id = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param('i', $project_id);
    $stmt->execute();
}

$query = "SELECT p.*, u.first_name, u.last_name FROM projects p JOIN users u ON p.user_id = u.id WHERE p.is_validated = 0";
$result = $mysqli->query($query);
$pending_projects = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Pending Projects</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #1a202c;
            color: #e2e8f0;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
        }
        h1 {
            color: #63b3ed;
            text-align: center;
        }
        .project-card {
            background-color: #2d3748;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
        }
        .project-title {
            color: #63b3ed;
            margin-top: 0;
        }
        .project-description {
            color: #a0aec0;
        }
        .project-creator {
            font-style: italic;
            color: #718096;
        }
        form {
            margin-top: 10px;
        }
        button {
            background-color: #48bb78;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #38a169;
        }
    </style>
</head>
<body>
<?php include __DIR__ . "/header.php"; ?>
<div class="container">
    <h1>Admin Panel - Pending Projects</h1>
    <?php if (empty($pending_projects)): ?>
        <p>No pending projects to review.</p>
    <?php else: ?>
        <?php foreach ($pending_projects as $project): ?>
            <div class="project-card">
                <h2 class="project-title"><?= htmlspecialchars($project['title']) ?></h2>
                <p class="project-description"><?= htmlspecialchars($project['description']) ?></p>
                <p class="project-creator">Created by: <?= htmlspecialchars($project['first_name'] . ' ' . $project['last_name']) ?></p>
                <form method="POST">
                    <input type="hidden" name="project_id" value="<?= $project['id'] ?>">
                    <button type="submit" name="approve">Approve Project</button>
                </form>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
</body>
</html>