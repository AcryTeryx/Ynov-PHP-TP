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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier le CV</title>
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
        form {
            display: flex;
            flex-direction: column;
        }
        label {
            margin-top: 1rem;
            color: #a0aec0;
        }
        input[type="text"],
        input[type="email"],
        input[type="date"],
        textarea {
            width: 100%;
            padding: 0.5rem;
            margin-top: 0.25rem;
            background-color: #4a5568;
            border: 1px solid #718096;
            border-radius: 4px;
            color: #e2e8f0;
        }
        button {
            margin-top: 1.5rem;
            padding: 0.75rem;
            background-color: #3182ce;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background-color: #2c5282;
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
    <?php include 'header.php'; ?>
    
    <main>
        <div class="container">
            <h1>Modifier le CV</h1>
            <form method="POST" action="edit_cv.php?id=<?php echo $cv_id; ?>">
                <label for="title">Titre:</label>
                <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($cv['title']); ?>" required>
                
                <label for="description">Description:</label>
                <textarea id="description" name="description"><?php echo htmlspecialchars($cv['description']); ?></textarea>
                
                <label for="profile_picture">Photo de profil (URL):</label>
                <input type="text" id="profile_picture" name="profile_picture" value="<?php echo htmlspecialchars($cv['profile_picture']); ?>">
                
                <label for="first_name">Prénom:</label>
                <input type="text" id="first_name" name="first_name" value="<?php echo htmlspecialchars($cv['first_name']); ?>">
                
                <label for="last_name">Nom:</label>
                <input type="text" id="last_name" name="last_name" value="<?php echo htmlspecialchars($cv['last_name']); ?>">
                
                <label for="birth_date">Date de naissance:</label>
                <input type="date" id="birth_date" name="birth_date" value="<?php echo htmlspecialchars($cv['birth_date']); ?>">
                
                <label for="phone">Téléphone:</label>
                <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($cv['phone']); ?>">
                
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($cv['email']); ?>">
                
                <label for="passions">Passions:</label>
                <textarea id="passions" name="passions"><?php echo htmlspecialchars($cv['passions']); ?></textarea>
                
                <label for="career">Carrière (JSON):</label>
                <textarea id="career" name="career"><?php echo htmlspecialchars($cv['career']); ?></textarea>
                
                <label for="education">Éducation (JSON):</label>
                <textarea id="education" name="education"><?php echo htmlspecialchars($cv['education']); ?></textarea>
                
                <label for="skills">Compétences (JSON):</label>
                <textarea id="skills" name="skills"><?php echo htmlspecialchars($cv['skills']); ?></textarea>
                
                <button type="submit">Mettre à jour le CV</button>
            </form>
        </div>
    </main>
    
    <?php include 'footer.php'; ?>
</body>
</html>