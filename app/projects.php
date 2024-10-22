<?php
session_start();

// Inclure le fichier database.php pour la connexion à la base de données
$mysqli = require __DIR__ . '/database.php';

// Vérifie si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// Récupération des projets de l'utilisateur
$query = "SELECT * FROM projects WHERE user_id = ?";
$stmt = $mysqli->prepare($query);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();
$projects = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/project.css">
    <title>Mes Projets</title>
</head>
<header>
    <?php include 'header.php' ?>
</header>
<body>
    <h1>Mes Projets</h1>

    <a href="create_projects.php">Ajouter un nouveau projet</a>

    <?php if (count($projects) > 0): ?>
        <ul>
            <?php foreach ($projects as $project): ?>
                <li>
                    <h2><?php echo htmlspecialchars($project['title']); ?></h2>
                    <p><?php echo htmlspecialchars($project['description']); ?></p>
                    <p>Créé le : <?php echo htmlspecialchars($project['created_at']); ?></p>
                    <p><?php echo $project['is_favorite'] ? "Favori" : ""; ?></p>
                    <p><?php echo $project['is_validated'] ? "Validé" : "En attente de validation"; ?></p>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>Vous n'avez pas encore ajouté de projets.</p>
    <?php endif; ?>
    <footer>
        <?php include 'footer.php'?>
    </footer>
</body>
</html>