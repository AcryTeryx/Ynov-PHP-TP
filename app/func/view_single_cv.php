<?php
session_start();
$mysqli = require __DIR__ . '/../../database.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: /app/login.php');
    exit();
}

if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("ID de CV manquant.");
}

$cv_id = $_GET['id'];
$query = "SELECT * FROM cvs WHERE id = ? AND user_id = ?";
$stmt = $mysqli->prepare($query);
$stmt->bind_param('ii', $cv_id, $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("CV non trouvé.");
}

$cv = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['delete_cv'])) {
    $delete_query = "DELETE FROM cvs WHERE id = ? AND user_id = ?";
    $delete_stmt = $mysqli->prepare($delete_query);
    $delete_stmt->bind_param('ii', $cv_id, $_SESSION['user_id']);
    if ($delete_stmt->execute()) {
        header("Location: /app/header.php");
        exit();
    } else {
        echo "Erreur lors de la suppression du CV.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/../../styles/view_cv.css">
    <link rel="stylesheet" href="/../../styles/header.css">
    <title>Voir le CV</title>
</head>
<?php include __DIR__ . '/../header.php'; ?>
<body>
    <div class="container">
        <h1><?php echo htmlspecialchars($cv['title']); ?></h1>
        <img src="<?php echo htmlspecialchars($cv['profile_picture']); ?>" alt="Photo de profil">
        <p><strong>Nom:</strong> <?php echo htmlspecialchars($cv['first_name'] . ' ' . $cv['last_name']); ?></p>
        <p><strong>Date de naissance:</strong> <?php echo htmlspecialchars($cv['birth_date']); ?></p>
        <p><strong>Téléphone:</strong> <?php echo htmlspecialchars($cv['phone']); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($cv['email']); ?></p>
        <p><strong>Passions:</strong> <?php echo htmlspecialchars($cv['passions']); ?></p>
        <h2>Carrière</h2>
        <pre><?php echo htmlspecialchars($cv['career']); ?></pre>
        <h2>Éducation</h2>
        <pre><?php echo htmlspecialchars($cv['education']); ?></pre>
        <h2>Compétences</h2>
        <pre><?php echo htmlspecialchars($cv['skills']); ?></pre>
        <a href="edit_cv.php?id=<?php echo $cv_id; ?>" class="btn">Modifier</a>
        <form method="POST" action="view_single_cv.php?id=<?php echo $cv_id; ?>">
            <input type="hidden" name="cv_id" value="<?php echo $cv_id; ?>">
            <button type="submit" name="delete_cv" class="btn-delete">Supprimer</button>
        </form>
    </div>
    <?php include __DIR__ .'/../footer.php'; ?>
</body>
</html>