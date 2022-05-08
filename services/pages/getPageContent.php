<?php
session_start();

require_once('../database.php');
include 'Page.php';

//Check user logged in
if (!isset($_SESSION["user"])) {
    header("Location: /login.php");
    exit();
}

// Check Request is POST
if (!isset($_POST)) {
    header("Location: /home.php");
    exit();
}

$pageContent = new Page;
echo (json_encode($pageContent->getPageContent($_POST['url'], $conn)));
exit();
