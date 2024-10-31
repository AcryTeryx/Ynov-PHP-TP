<?php
session_start();
$mysqli = require __DIR__ . '/../../database.php';

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
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../styles/view_cv.css">
    <title>Voir mes CV</title>
</head>
<body>
    <?php include 'header.php'; ?>
    <div class="container">
        <h1>Voir mes CV</h1>
        <?php if (count($cvs) > 0): ?>
            <ul>
                <?php foreach ($cvs as $cv): ?>
                    <li>
                        <h2><?php echo htmlspecialchars($cv['title']); ?></h2>
                        <a href="view_single_cv.php?id=<?php echo $cv['id']; ?>" class="btn">Voir ce CV</a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>Vous n'avez pas encore créé de CV.</p>
        <?php endif; ?>
    </div>
    <?php include 'footer.php'; ?>
</body>
</html>