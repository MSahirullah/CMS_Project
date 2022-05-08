<?php
include '../Auth.php';
session_start();

//check user logged in
if (!(isset($_SESSION["user"]) && $_SESSION["user"])) {
    Header("Location: /login.php");
    exit();
}

$logoutUser = new Auth;
$logoutUser->logout('user');
exit();
