<?php
// Start PHP session to store and retrieve user information
session_start();

// Set default personal information if not already set
if (!isset($_SESSION['name'])) {
    $_SESSION['name'] = "John Doe";
    $_SESSION['title'] = "Web Developer | Programmer | Tech Enthusiast";
    $_SESSION['email'] = "johndoe@example.com";
    $_SESSION['phone'] = "(123) 456-7890";
    $_SESSION['profileDescription'] = "I am a passionate web developer with experience in creating dynamic websites and applications. Skilled in HTML, CSS, JavaScript, and backend technologies like Node.js.";
}

// Update personal information on form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $_SESSION['name'] = $_POST['name'];
    $_SESSION['title'] = $_POST['title'];
    $_SESSION['email'] = $_POST['email'];
    $_SESSION['phone'] = $_POST['phone'];
    $_SESSION['profileDescription'] = $_POST['profileDescription'];
}
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
            <h1><?php echo $_SESSION['name']; ?></h1>
            <p><?php echo $_SESSION['title']; ?></p>
            <p>Email: <?php echo $_SESSION['email']; ?> | Phone: <?php echo $_SESSION['phone']; ?></p>
            <button id="editBtn">Edit Personal Info</button>
        </header>

        <!-- Profile Section -->
        <section class="profile">
            <h2>Profile</h2>
            <p><?php echo $_SESSION['profileDescription']; ?></p>
        </section>

        <!-- Other sections remain the same... -->

        <!-- Modal for updating personal information -->
        <div id="myModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <h2>Edit Personal Information</h2>
                <form method="POST" action="">
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" value="<?php echo $_SESSION['name']; ?>" required>

                    <label for="title">Title:</label>
                    <input type="text" id="title" name="title" value="<?php echo $_SESSION['title']; ?>" required>

                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" value="<?php echo $_SESSION['email']; ?>" required>

                    <label for="phone">Phone:</label>
                    <input type="text" id="phone" name="phone" value="<?php echo $_SESSION['phone']; ?>" required>

                    <label for="profileDescription">Profile Description:</label>
                    <textarea id="profileDescription" name="profileDescription" required><?php echo $_SESSION['profileDescription']; ?></textarea>

                    <input type="submit" value="Save Changes">
                </form>
            </div>
        </div>
    </div>

    <script>
        // Get modal and elements
        var modal = document.getElementById("myModal");
        var btn = document.getElementById("editBtn");
        var span = document.getElementsByClassName("close")[0];

        // Open the modal when the edit button is clicked
        btn.onclick = function() {
            modal.style.display = "block";
        }

        // Close the modal when the 'x' is clicked
        span.onclick = function() {
            modal.style.display = "none";
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
