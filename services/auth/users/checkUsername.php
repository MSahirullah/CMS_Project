<?php
session_start();

require_once('../../database.php');
include '../../users/User.php';

//check user logged in
if (isset($_SESSION["user"]) && $_SESSION["user"]) {
    Header("Location: /homepage.php");
    exit();
}

// Check Request is POST
if (!isset($_POST)) {
    header("Location: /login.php");
    exit();
}

$user = new User;
print_r($user->checkUsername($_POST['username'], $conn));
exit();
