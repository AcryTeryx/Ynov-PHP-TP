<?php
require "config.php";
if (isset($_POST['submit'])) {
    require 'config.php';
    $name = $_POST['name'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmpassword = $_POST['confirmpassword'];
    $duplicate = mysqli_query($conn, "SELECT * FROM tbl_user WHERE username= '$username' OR email='$email'");
    if (mysqli_num_rows($duplicate) > 0) {
        echo "<script> alerte('Username or Email has already been used'); </script>";
    } else

    if ($password == $confirmpassword) {
        $sql = "INSERT INTO tbl_user (name, username, email, password) VALUES ('', '$name', '$username', '$email', '$password')";
        $result = mysqli_query($conn, $query);
        mysqli_query($conn, $sql);
            echo "<script> alerte('Registration Successful'); </script>";
        } else {
            echo "<script> alerte('Password does not match'); </script>"
        }
    }


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
</head>
<body>
<h2>Registration</h2>
<form action="" method="POST" autocomplete="off" >    
    <label for="name">Name : </label>
    <input type="text" name="name" id="name" required value=""> <br>

    <label for="username">Username : </label>
    <input type="text" name="username" id="username" required value=""> <br>

    <label for="email">Email : </label>
    <input type="text" name="email" id="email" required value=""> <br>

    <label for="password">Password : </label>
    <input type="text" name="password" id="password" required value=""> <br>

    <label for="confirmpassword">Confirm Password : </label>
    <input type="text" name="confirmpassword" id="confirmpassword" required value=""> <br>
    <button type="submit" name="submit" >Register</button>
</form>
<br>
<a href="login.php">Login</a>
</body>
</html>