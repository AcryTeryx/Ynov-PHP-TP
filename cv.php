<?php
session_start();
$mysqli = require __DIR__ . '/database.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM cvs WHERE user_id = ?";
$stmt = $mysqli->prepare($query);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();
$cvs = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionnaire de CV</title>
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
        .view-button {
            background-color: #48bb78;
        }
        .view-button:hover {
            background-color: #38a169;
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
                <li><a href="index.php">Home</a></li>
                <li><a href="user_profile.php">Profile</a></li>
                <li><a href="cv.php">CV</a></li>
                <li><a href="projects.php">Mes projets</a></li>
                <li><a href="logout.php">Déconnexion</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <div class="container">
            <h1>Gestionnaire de CV</h1>
            <div class="button-group">
                <a href="create_cv.php" class="button create-button">Créer un nouveau CV</a>
            </div>
            <div class="cv-list">
                <?php if (count($cvs) > 0): ?>
                    <?php foreach ($cvs as $cv): ?>
                        <div class="cv-item">
                            <h2><?= htmlspecialchars($cv['title']) ?></h2>
                            <p><?= htmlspecialchars($cv['description']) ?></p>
                            <p>Créé le : <?= htmlspecialchars($cv['created_at']) ?></p>
                            <a href="view_single_cv.php?id=<?= $cv['id'] ?>" class="button view-button">Voir ce CV</a>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>Aucun CV trouvé. Créez votre premier CV !</p>
                <?php endif; ?>
            </div>
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