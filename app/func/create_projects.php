<?php
session_start();

$mysqli = require __DIR__ . '/../../database.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $is_favorite = isset($_POST['is_favorite']) ? 1 : 0;
    
    $query = "INSERT INTO projects (user_id, title, description, is_favorite) VALUES (?, ?, ?, ?)";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param('issi', $user_id, $title, $description, $is_favorite);
    
    if ($stmt->execute()) {
        header('Location: projects.php');
        exit();
    } else {
        echo "Erreur lors de la création du projet.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer un projet</title>
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
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }

        h1 {
            color: #63b3ed;
            text-align: center;
            margin-bottom: 1.5rem;
        }

        form {
            background-color: #2d3748;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 20px;
        }

        form label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #a0aec0;
        }

        form input[type="text"],
        form textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #4a5568;
            border-radius: 4px;
            box-sizing: border-box;
            background-color: #4a5568;
            color: #e2e8f0;
        }

        form input[type="checkbox"] {
            margin-bottom: 15px;
        }

        button[type="submit"] {
            background-color: #3182ce;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button[type="submit"]:hover {
            background-color: #2c5282;
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
    </style>
</head>
<body>
    <?php include 'header.php'; ?>
    <div class="container">
        <h1>Créer un nouveau projet</h1>

        <form method="POST" action="create_projects.php">
            <label for="title">Titre:</label>
            <input type="text" id="title" name="title" required>

            <label for="description">Description:</label>
            <textarea id="description" name="description" required></textarea>

            <label for="is_favorite">
                <input type="checkbox" id="is_favorite" name="is_favorite">
                Marquer comme favori
            </label>

            <button type="submit">Créer le projet</button>
        </form>
    </div>
    <?php include 'footer.php'; ?>
</body>
</html>