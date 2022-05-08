<?php
session_start();

require_once('../../services/database.php');
include 'Page.php';

//Check Admin logged in
if (!(isset($_SESSION["admin"]) && $_SESSION["admin"])) {
    Header("Location: /admin/login.php");
    exit();
}

// Check Request is POST
if (!isset($_POST)) {
    Header("Location: admin/index.php");
    exit();
}

$updatePage = new Page();
exit($updatePage->updatePage($_POST, $_FILES,  $conn));
