<?php
session_start();
include 'header.php'; // Inclusion de l'en-tête
include 'database.php'; // Connexion à la base de données

// Vérification de la session utilisateur
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Récupération des CV de l'utilisateur
$sql = "SELECT * FROM cvs WHERE user_id = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$cvs = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes CV</title>
    <link rel="stylesheet" href="styles/cv.css">
</head>
<body>
    <div class="container">
        <h1>Mes CV</h1>
        <div class="buttons">
            <a href="create_cv.php" class="btn">Créer un nouveau CV</a>
            <a href="view_cv.php" class="btn">Voir mes CV</a>
        </div>
        <?php if (count($cvs) > 0): ?>
            <ul>
                <?php foreach ($cvs as $cv): ?>
                    <li>
                        <h2><?= htmlspecialchars($cv['title']) ?></h2>
                        <p><?= htmlspecialchars($cv['description']) ?></p>
                        <p>Créé le : <?= htmlspecialchars($cv['created_at']) ?></p>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>Aucun CV trouvé.</p>
        <?php endif; ?>
    </div>
</body>
</html>