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

// Récupération des informations de l'utilisateur connecté
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Mise à jour des informations
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $password = $_POST['password']; // Assurez-vous de gérer le hachage du mot de passe lors de la modification
    
    // Si le mot de passe est modifié, on le hache
    if (!empty($password)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $update_query = "UPDATE users SET first_name = ?, last_name = ?, email = ?, password = ? WHERE id = ?";
        $stmt = $mysqli->prepare($update_query);
        $stmt->bind_param('ssssi', $first_name, $last_name, $email, $hashed_password, $user_id);
    } else {
        // Si le mot de passe n'est pas modifié, ne pas le changer dans la base de données
        $update_query = "UPDATE users SET first_name = ?, last_name = ?, email = ? WHERE id = ?";
        $stmt = $mysqli->prepare($update_query);
        $stmt->bind_param('sssi', $first_name, $last_name, $email, $user_id);
    }
    
    if ($stmt->execute()) {
        echo "Les informations ont été mises à jour avec succès.";
    } else {
        echo "Erreur lors de la mise à jour des informations.";
    }
}

// Récupération des informations actuelles de l'utilisateur
$query = "SELECT * FROM users WHERE id = ?";
$stmt = $mysqli->prepare($query);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/profile.css">
    <title>Profil utilisateur</title>
</head>
<body>
    <header>
        <?php include 'header.php'; ?>
    </header>
    <h1>Profil de <?php echo htmlspecialchars($user['first_name']) . " " . htmlspecialchars($user['last_name']); ?></h1>
    
    <form method="POST" action="profile.php">
        <label for="first_name">Prénom:</label>
        <input type="text" id="first_name" name="first_name" value="<?php echo htmlspecialchars($user['first_name']); ?>" required>
        <br>

        <label for="last_name">Nom:</label>
        <input type="text" id="last_name" name="last_name" value="<?php echo htmlspecialchars($user['last_name']); ?>" required>
        <br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
        <br>

        <label for="password">Mot de passe (laisser vide pour ne pas changer):</label>
        <input type="password" id="password" name="password">
        <br>

        <button type="submit">Mettre à jour</button>
    </form>

    <p>Date de création du compte : <?php echo htmlspecialchars($user['created_at']); ?></p>
    <p>Rôle : <?php echo htmlspecialchars($user['role']); ?></p>
     <footer>
        <?php include 'footer.php'; ?>
     </footer>
</body>
</html>
