<?php
include '../Auth.php';
session_start();

//check admin logged in
if (!(isset($_SESSION["admin"]) && $_SESSION["admin"])) {
    Header("Location: /admin/login.php");
    exit();
}

$logoutUser = new Auth;
$logoutUser->logout('admin');
exit();
