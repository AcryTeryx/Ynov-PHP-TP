<?php
function checkAdminRole($user) {
    if ($user['role'] !== 'admin') {
        header('Location: /../notAdmin.php');
        exit();
    }
}
?>