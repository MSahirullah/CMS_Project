<?php
session_start();

require_once('../../database.php');
include '../../users/User.php';

//check user logged in
if (isset($_SESSION["user"]) && $_SESSION["user"]) {
    Header("Location: /home.php");
    exit();
}

//check is POST request
if (!isset($_POST)) {
    $_SESSION["register_status"] = ['alert-danger', "Invaid Request"];
    Header("Location: /registration.php");
    exit();
}

$newUser = new User;
$newUser->register($_POST, $conn);
exit();
