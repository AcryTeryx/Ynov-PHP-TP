<?php
session_start();
$mysqli = require __DIR__ . '/database.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

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

    $query = "INSERT INTO cvs (user_id, title, description, profile_picture, first_name, last_name, birth_date, phone, email, passions, career, education, skills) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param('issssssssssss', $user_id, $title, $description, $profile_picture, $first_name, $last_name, $birth_date, $phone, $email, $passions, $career, $education, $skills);

    if ($stmt->execute()) {
        $cv_id = $stmt->insert_id;
        header("Location: view_cv.php?id=$cv_id");
        exit();
    } else {
        echo "Erreur lors de la création du CV.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/create_cv.css">
    <title>Créer un CV</title>
</head>
<?php include 'header.php'; ?>
<body>
    <h1>Créer un CV</h1>
    <form method="POST" action="create_cv.php">
        <label for="title">Titre:</label>
        <input type="text" id="title" name="title" required>
        <br>
        <label for="description">Description:</label>
        <textarea id="description" name="description"></textarea>
        <br>
        <label for="profile_picture">Photo de profil (URL):</label>
        <input type="text" id="profile_picture" name="profile_picture">
        <br>
        <label for="first_name">Prénom:</label>
        <input type="text" id="first_name" name="first_name">
        <br>
        <label for="last_name">Nom:</label>
        <input type="text" id="last_name" name="last_name">
        <br>
        <label for="birth_date">Date de naissance:</label>
        <input type="date" id="birth_date" name="birth_date">
        <br>
        <label for="phone">Téléphone:</label>
        <input type="text" id="phone" name="phone">
        <br>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email">
        <br>
        <label for="passions">Passions:</label>
        <textarea id="passions" name="passions"></textarea>
        <br>
        <label for="career">Carrière (JSON):</label>
        <textarea id="career" name="career"></textarea>
        <br>
        <label for="education">Éducation (JSON):</label>
        <textarea id="education" name="education"></textarea>
        <br>
        <label for="skills">Compétences (JSON):</label>
        <textarea id="skills" name="skills"></textarea>
        <br>
        <button type="submit">Créer le CV</button>
    </form>
    <?php include 'footer.php'; ?>
</body>
</html><?php
session_start();
$mysqli = require __DIR__ . '/database.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

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

    $query = "INSERT INTO cvs (user_id, title, description, profile_picture, first_name, last_name, birth_date, phone, email, passions, career, education, skills) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param('issssssssssss', $user_id, $title, $description, $profile_picture, $first_name, $last_name, $birth_date, $phone, $email, $passions, $career, $education, $skills);

    if ($stmt->execute()) {
        $cv_id = $stmt->insert_id;
        header("Location: view_cv.php?id=$cv_id");
        exit();
    } else {
        echo "Erreur lors de la création du CV.";
    }
}
?>
