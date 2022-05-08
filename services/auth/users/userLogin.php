<?php
session_start();

require_once('../../database.php');
include '../Auth.php';

//check user logged in
if (isset($_SESSION["user"]) && $_SESSION["user"]) {
    Header("Location: /home.php");
    exit();
}

// Check Request is POST
if (!isset($_POST)) {
    header("Location: /login.php");
    exit();
}

$userAuth = new Auth;
$userAuth->userLogin($_POST, $conn);
exit();
