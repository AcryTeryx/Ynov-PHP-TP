<?php
session_start();
require 'db.php'; // Include the database connection

// Check if the user is logged in as admin
$isAdmin = isset($_SESSION['is_admin']) && $_SESSION['is_admin'];

// Fetch personal information from the database
$stmt = $pdo->prepare('SELECT * FROM personal_info WHERE id = 1');
$stmt->execute();
$personalInfo = $stmt->fetch();

// Handle form submission and update the database (admin only)
if ($_SERVER["REQUEST_METHOD"] == "POST" && $isAdmin) {
    $name = $_POST['name'];
    $title = $_POST['title'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $profileDescription = $_POST['profileDescription'];

    // Update personal information in the database
    $stmt = $pdo->prepare('UPDATE personal_info SET name = ?, title = ?, email = ?, phone = ?, profile_description = ? WHERE id = 1');
    $stmt->execute([$name, $title, $email, $phone, $profileDescription]);

    // Redirect to the CV page to reflect the changes
    header("Location: index.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Curriculum Vitae</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <!-- Header Section -->
        <header>
            <h1><?php echo $personalInfo['name']; ?></h1>
            <p><?php echo $personalInfo['title']; ?></p>
            <p>Email: <?php echo $personalInfo['email']; ?> | Phone: <?php echo $personalInfo['phone']; ?></p>
            <?php if ($isAdmin): ?>
                <button id="editBtn">Edit Personal Info</button>
                <a href="logout.php">Logout</a>
            <?php else: ?>
                <a href="login.php">Admin Login</a>
            <?php endif; ?>
        </header>

        <!-- Profile Section -->
        <section class="profile">
            <h2>Profile</h2>
            <p><?php echo $personalInfo['profile_description']; ?></p>
        </section>

        <!-- Modal for updating personal information (visible only for admin) -->
        <?php if ($isAdmin): ?>
        <div id="myModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <h2>Edit Personal Information</h2>
                <form method="POST" action="">
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" value="<?php echo $personalInfo['name']; ?>" required>

                    <label for="title">Title:</label>
                    <input type="text" id="title" name="title" value="<?php echo $personalInfo['title']; ?>" required>

                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" value="<?php echo $personalInfo['email']; ?>" required>

                    <label for="phone">Phone:</label>
                    <input type="text" id="phone" name="phone" value="<?php echo $personalInfo['phone']; ?>" required>

                    <label for="profileDescription">Profile Description:</label>
                    <textarea id="profileDescription" name="profileDescription" required><?php echo $personalInfo['profile_description']; ?></textarea>

                    <input type="submit" value="Save Changes">
                </form>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <script>
        // Get modal and elements
        var modal = document.getElementById("myModal");
        var btn = document.getElementById("editBtn");
        var span = document.getElementsByClassName("close")[0];

        // Open the modal when the edit button is clicked
        if (btn) {
            btn.onclick = function() {
                modal.style.display = "block";
            }
        }

        // Close the modal when the 'x' is clicked
        if (span) {
            span.onclick = function() {
                modal.style.display = "none";
            }
        }

        // Close the modal if the user clicks outside the modal content
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>
</body>
</html>
