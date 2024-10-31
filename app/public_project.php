<?php
session_start();
$mysqli = require __DIR__ . '/../database.php';

// Fetch all approved projects
$query = "SELECT p.*, u.first_name, u.last_name FROM projects p JOIN users u ON p.user_id = u.id WHERE p.is_validated = 1 ORDER BY p.created_at DESC";
$result = $mysqli->query($query);
$approved_projects = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Public Projects</title>
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
        .project-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
        }
        .project-card {
            background-color: #2d3748;
            border-radius: 8px;
            padding: 20px;
            transition: transform 0.3s ease;
        }
        .project-card:hover {
            transform: translateY(-5px);
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
        .project-date {
            color: #718096;
            font-size: 0.9em;
        }
    </style>
</head>
<body>
<header>
    <?php include 'header.php' ?>
</header>
<div class="container">
    <h1>Public Projects</h1>
    <div class="project-grid">
        <?php if (empty($approved_projects)): ?>
            <p>No approved projects to display.</p>
        <?php else: ?>
            <?php foreach ($approved_projects as $project): ?>
                <div class="project-card">
                    <h2 class="project-title"><?= htmlspecialchars($project['title']) ?></h2>
                    <p class="project-description"><?= htmlspecialchars($project['description']) ?></p>
                    <p class="project-creator">Created by: <?= htmlspecialchars($project['first_name'] . ' ' . $project['last_name']) ?></p>
                    <p class="project-date">Created on: <?= date('F j, Y', strtotime($project['created_at'])) ?></p>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>
<footer>
    <?php include 'footer.php' ?>
</footer>
</body>
</html>