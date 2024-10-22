<?php
session_start();
$mysqli = require __DIR__ . '/database.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
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

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $profile_picture = $_POST['profile_picture'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $birth_date = $_POST['birth_date'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $passions = $_POST['passions'];
    $career = json_encode($_POST['career']);
    $education = json_encode($_POST['education']);
    $skills = json_encode($_POST['skills']);

    $query = "UPDATE cvs SET title = ?, description = ?, profile_picture = ?, first_name = ?, last_name = ?, birth_date = ?, phone = ?, email = ?, passions = ?, career = ?, education = ?, skills = ? WHERE id = ? AND user_id = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param('sssssssssssssi', $title, $description, $profile_picture, $first_name, $last_name, $birth_date, $phone, $email, $passions, $career, $education, $skills, $cv_id, $_SESSION['user_id']);

    if ($stmt->execute()) {
        header("Location: view_single_cv.php?id=$cv_id");
        exit();
    } else {
        echo "Erreur lors de la mise à jour du CV.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/edit_cv.css">
    <title>Modifier le CV</title>
</head>
<?php include 'header.php'; ?>
<body>
    <h1>Modifier le CV</h1>
    <form method="POST" action="edit_cv.php?id=<?php echo $cv_id; ?>">
        <label for="title">Titre:</label>
        <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($cv['title']); ?>" required>
        <br>
        <label for="description">Description:</label>
        <textarea id="description" name="description"><?php echo htmlspecialchars($cv['description']); ?></textarea>
        <br>
        <label for="profile_picture">Photo de profil (URL):</label>
        <input type="text" id="profile_picture" name="profile_picture" value="<?php echo htmlspecialchars($cv['profile_picture']); ?>">
        <br>
        <label for="first_name">Prénom:</label>
        <input type="text" id="first_name" name="first_name" value="<?php echo htmlspecialchars($cv['first_name']); ?>">
        <br>
        <label for="last_name">Nom:</label>
        <input type="text" id="last_name" name="last_name" value="<?php echo htmlspecialchars($cv['last_name']); ?>">
        <br>
        <label for="birth_date">Date de naissance:</label>
        <input type="date" id="birth_date" name="birth_date" value="<?php echo htmlspecialchars($cv['birth_date']); ?>">
        <br>
        <label for="phone">Téléphone:</label>
        <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($cv['phone']); ?>">
        <br>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($cv['email']); ?>">
        <br>
        <label for="passions">Passions:</label>
        <textarea id="passions" name="passions"><?php echo htmlspecialchars($cv['passions']); ?></textarea>
        <br>
        <label for="career">Carrière (JSON):</label>
        <textarea id="career" name="career"><?php echo htmlspecialchars($cv['career']); ?></textarea>
        <br>
        <label for="education">Éducation (JSON):</label>
        <textarea id="education" name="education"><?php echo htmlspecialchars($cv['education']); ?></textarea>
        <br>
        <label for="skills">Compétences (JSON):</label>
        <textarea id="skills" name="skills"><?php echo htmlspecialchars($cv['skills']); ?></textarea>
        <br>
        <button type="submit">Mettre à jour le CV</button>
    </form>
    <?php include 'footer.php'; ?>
</body>
</html>