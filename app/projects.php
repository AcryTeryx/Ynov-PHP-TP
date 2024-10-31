<?php
session_start();


$mysqli = require __DIR__ . '/../database.php';


if (!isset($_SESSION['user_id'])) {
    header('Location: /app/func/login.php');
    exit();
}

$user_id = $_SESSION['user_id'];


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
    <title>Mes Projets</title>
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

        a {
            color: #63b3ed;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        h1 {
            color: #63b3ed;
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .validation-status {
            font-weight: bold;
            padding: 10px;
            border-radius: 5px;
            display: inline-block;
        }

        header, footer {
            background-color: #2f4f6f;
            color: #e2e8f0;
            padding: 10px 0;
            text-align: center;
        }

        header {
            margin-bottom: 20px;
        }

        footer {
            margin-top: 40px;
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        li {
            background-color: #2d3748;
            border-radius: 8px;
            margin-bottom: 20px;
            padding: 20px;
        }

        li h2 {
            color: #63b3ed;
            margin-top: 0;
        }

        li p {
            color: #a0aec0;
        }
    </style>
</head>
<body>
    <header>
        <?php include 'header.php' ?>
    </header>
    <div class="container">
        <h1>Mes Projets</h1>

        <a href="func/create_projects.php">Ajouter un nouveau projet</a>

        <?php if (count($projects) > 0): ?>
            <ul>
                <?php foreach ($projects as $project): ?>
                    <li>
                        <h2><?php echo htmlspecialchars($project['title']); ?></h2>
                        <p><?php echo htmlspecialchars($project['description']); ?></p>
                        <p>Créé le : <?php echo htmlspecialchars($project['created_at']); ?></p>
                        <p><?php echo $project['is_favorite'] ? "Favori" : ""; ?></p>
                        <p class="validation-status <?php echo $project['is_validated'] ? 'validated' : 'pending'; ?>">
                            <?php echo $project['is_validated'] ? "Validé" : "En attente de validation"; ?>
                        </p>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>Vous n'avez pas encore ajouté de projets.</p>
        <?php endif; ?>
    </div>
    <footer>
        <?php include 'footer.php' ?>
    </footer>
</body>
</html>