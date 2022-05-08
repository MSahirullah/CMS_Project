<?php
session_start();

require_once('../../database.php');
include '../Auth.php';

//Check Admin logged in
if (isset($_SESSION["admin"]) && $_SESSION["admin"]) {
    Header("Location: /admin/dashboard.php");
    exit();
}

// Check Request is POST
if (!isset($_POST)) {
    Header("Location: admin/index.php");
    exit();
}

$adminAuth = new Auth;
$adminAuth->adminLogin($_POST, $conn);
exit();
