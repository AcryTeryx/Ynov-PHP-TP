<?php
// Start session to track admin login status
session_start();

// If the user is not logged in as admin, prevent access to editing
$isAdmin = isset($_SESSION['is_admin']) && $_SESSION['is_admin'];

// Set default personal information
$defaultName = "John Doe";
$defaultTitle = "Web Developer | Programmer | Tech Enthusiast";
$defaultEmail = "johndoe@example.com";
$defaultPhone = "(123) 456-7890";
$defaultProfileDescription = "I am a passionate web developer with experience in creating dynamic websites and applications. Skilled in HTML, CSS, JavaScript, and backend technologies like Node.js.";

// Handle form submission and set cookies
if ($_SERVER["REQUEST_METHOD"] == "POST" && $isAdmin) {
    setcookie('name', $_POST['name'], time() + (86400 * 30), "/"); // 86400 = 1 day
    setcookie('title', $_POST['title'], time() + (86400 * 30), "/");
    setcookie('email', $_POST['email'], time() + (86400 * 30), "/");
    setcookie('phone', $_POST['phone'], time() + (86400 * 30), "/");
    setcookie('profileDescription', $_POST['profileDescription'], time() + (86400 * 30), "/");
    // Reload the page to update cookie values
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Retrieve data from cookies or use defaults if cookies are not set
$name = isset($_COOKIE['name']) ? $_COOKIE['name'] : $defaultName;
$title = isset($_COOKIE['title']) ? $_COOKIE['title'] : $defaultTitle;
$email = isset($_COOKIE['email']) ? $_COOKIE['email'] : $defaultEmail;
$phone = isset($_COOKIE['phone']) ? $_COOKIE['phone'] : $defaultPhone;
$profileDescription = isset($_COOKIE['profileDescription']) ? $_COOKIE['profileDescription'] : $defaultProfileDescription;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Curriculum Vitae</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <!-- Header Section -->
        <header>
            <h1><?php echo $name; ?></h1>
            <p><?php echo $title; ?></p>
            <p>Email: <?php echo $email; ?> | Phone: <?php echo $phone; ?></p>
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
            <p><?php echo $profileDescription; ?></p>
        </section>

        <!-- Modal for updating personal information (visible only for admin) -->
        <?php if ($isAdmin): ?>
        <div id="myModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <h2>Edit Personal Information</h2>
                <form method="POST" action="">
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" value="<?php echo $name; ?>" required>

                    <label for="title">Title:</label>
                    <input type="text" id="title" name="title" value="<?php echo $title; ?>" required>

                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" value="<?php echo $email; ?>" required>

                    <label for="phone">Phone:</label>
                    <input type="text" id="phone" name="phone" value="<?php echo $phone; ?>" required>

                    <label for="profileDescription">Profile Description:</label>
                    <textarea id="profileDescription" name="profileDescription" required><?php echo $profileDescription; ?></textarea>

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
