<?php
session_start();
$mysqli = require __DIR__ . '/../database.php';

// Fetch all projects, ordered by favorite status (favorites first) and then by creation date
$query = "SELECT p.*, u.first_name, u.last_name FROM projects p 
          JOIN users u ON p.user_id = u.id 
          WHERE p.is_validated = 1
          ORDER BY p.is_project_favorite DESC, p.created_at DESC";
$result = $mysqli->query($query);
$projects = $result->fetch_all(MYSQLI_ASSOC);

// Handle favoriting/unfavoriting
if (isset($_POST['toggle_favorite']) && isset($_SESSION['user_id'])) {
    $project_id = $_POST['project_id'];
    $current_status = $_POST['current_status'];
    $new_status = $current_status ? 0 : 1;

    $update_query = "UPDATE projects SET is_project_favorite = ? WHERE id = ?";
    $stmt = $mysqli->prepare($update_query);
    $stmt->bind_param('ii', $new_status, $project_id);
    $stmt->execute();

    // Redirect to refresh the page and avoid form resubmission
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}
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
            position: relative;
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
        .favorite-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
            color: #f6e05e;
        }
        .favorite-icon {
            transition: transform 0.3s ease;
        }
        .favorite-btn:hover .favorite-icon {
            transform: scale(1.2);
        }
        .favorite-label {
            background-color: #f6e05e;
            color: #1a202c;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 0.8em;
            position: absolute;
            top: 10px;
            left: 10px;
        }
    </style>
</head>
<body>
<header>
    <?php include 'header.php'; ?>
</header>
<div class="container">
    <h1>Public Projects</h1>
    <div class="project-grid">
        <?php if (empty($projects)): ?>
            <p>No projects to display.</p>
        <?php else: ?>
            <?php foreach ($projects as $project): ?>
                <div class="project-card">
                    <?php if ($project['is_project_favorite']): ?>
                        <span class="favorite-label">Favorite</span>
                    <?php endif; ?>
                    <h2 class="project-title"><?= htmlspecialchars($project['title']) ?></h2>
                    <p class="project-description"><?= htmlspecialchars($project['description']) ?></p>
                    <p class="project-creator">Created by: <?= htmlspecialchars($project['first_name'] . ' ' . $project['last_name']) ?></p>
                    <p class="project-date">Created on: <?= date('F j, Y', strtotime($project['created_at'])) ?></p>
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <form method="POST">
                            <input type="hidden" name="project_id" value="<?= $project['id'] ?>">
                            <input type="hidden" name="current_status" value="<?= $project['is_project_favorite'] ?>">
                            <button type="submit" name="toggle_favorite" class="favorite-btn">
                                <span class="favorite-icon"><?= $project['is_project_favorite'] ? '★' : '☆' ?></span>
                            </button>
                        </form>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>
<footer>
    <?php include 'footer.php'; ?>
</footer>
</body>
</html>