<?php

require_once('../../services/database.php');
include 'User.php';

//Check Admin logged in
if (!(isset($_SESSION["admin"]) && $_SESSION["admin"])) {
    Header("Location: /admin/login.php");
    exit();
}

$usersDetails = new User;
$users = $usersDetails->getAllUsers($conn);
$rowCount = $users->rowCount();
