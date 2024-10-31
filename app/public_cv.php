<?php
session_start();
$mysqli = require __DIR__ . '/../database.php';
require __DIR__ . '/func/generate_pdf.php';

$query = "SELECT c.*, u.first_name, u.last_name FROM cvs c 
          JOIN users u ON c.user_id = u.id 
          ORDER BY c.is_favorite DESC, c.created_at DESC";
$result = $mysqli->query($query);
$cvs = $result->fetch_all(MYSQLI_ASSOC);


if (isset($_POST['toggle_favorite']) && isset($_SESSION['user_id'])) {
    $cv_id = $_POST['cv_id'];
    $current_status = $_POST['current_status'];
    $new_status = $current_status ? 0 : 1;

    $update_query = "UPDATE cvs SET is_favorite = ? WHERE id = ?";
    $stmt = $mysqli->prepare($update_query);
    $stmt->bind_param('ii', $new_status, $cv_id);
    $stmt->execute();


    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}


if (isset($_GET['download_pdf'])) {
    $cv_id = $_GET['download_pdf'];
    $query = "SELECT c.*, u.first_name, u.last_name FROM cvs c 
              JOIN users u ON c.user_id = u.id 
              WHERE c.id = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param('i', $cv_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $cv = $result->fetch_assoc();

    if ($cv) {
        $pdf_content = generateCVPDF($cv);
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="' . $cv['title'] . '.pdf"');
        echo $pdf_content;
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Public CVs</title>
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
        .cv-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
        }
        .cv-card {
            background-color: #2d3748;
            border-radius: 8px;
            padding: 20px;
            transition: transform 0.3s ease;
            position: relative;
        }
        .cv-card:hover {
            transform: translateY(-5px);
        }
        .cv-title {
            color: #63b3ed;
            margin-top: 0;
        }
        .cv-description {
            color: #a0aec0;
        }
        .cv-creator {
            font-style: italic;
            color: #718096;
        }
        .cv-date {
            color: #718096;
            font-size: 0.9em;
        }
        .action-buttons {
            position: absolute;
            top: 10px;
            right: 10px;
            display: flex;
            gap: 10px;
        }
        .favorite-btn, .download-btn {
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
            color: #f6e05e;
            transition: transform 0.3s ease;
        }
        .favorite-btn:hover, .download-btn:hover {
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
    <?php include 'header.php' ?>
</header>
<div class="container">
    <h1>Public CVs</h1>
    <div class="cv-grid">
        <?php if (empty($cvs)): ?>
            <p>No CVs to display.</p>
        <?php else: ?>
            <?php foreach ($cvs as $cv): ?>
                <div class="cv-card">
                    <?php if ($cv['is_favorite']): ?>
                        <span class="favorite-label">Favorite</span>
                    <?php endif; ?>
                    <h2 class="cv-title"><?= htmlspecialchars($cv['title']) ?></h2>
                    <p class="cv-description"><?= htmlspecialchars($cv['description']) ?></p>
                    <p class="cv-creator">Created by: <?= htmlspecialchars($cv['first_name'] . ' ' . $cv['last_name']) ?></p>
                    <p class="cv-date">Created on: <?= date('F j, Y', strtotime($cv['created_at'])) ?></p>
                    <div class="action-buttons">
                        <?php if (isset($_SESSION['user_id'])): ?>
                            <form method="POST" style="display: inline;">
                                <input type="hidden" name="cv_id" value="<?= $cv['id'] ?>">
                                <input type="hidden" name="current_status" value="<?= $cv['is_favorite'] ?>">
                                <button type="submit" name="toggle_favorite" class="favorite-btn">
                                    <?= $cv['is_favorite'] ? '★' : '☆' ?>
                                </button>
                            </form>
                        <?php endif; ?>
                        <a href="?download_pdf=<?= $cv['id'] ?>" class="download-btn" title="Download PDF">📥</a>
                    </div>
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