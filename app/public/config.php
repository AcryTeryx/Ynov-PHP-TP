<?php 
session_start();

$conn = mysqli_connect ("localhost", "root", "", "reglog");

if (!$conn) {
    die("Error connecting to database: " . mysqli_connect_error());
}

define ('ROOT_PATH', realpath(dirname(app/index.php)));

define ('BASE_URL', 'http://localhost/registration-login-system-php/');

?>