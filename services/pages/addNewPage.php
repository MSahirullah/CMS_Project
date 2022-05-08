<?php
session_start();

require_once('../../services/database.php');
include 'Page.php';

// Check Admin logged in
if (!(isset($_SESSION["admin"]) && $_SESSION["admin"])) {
    Header("Location: /admin/login.php");
    exit();
}

if (!isset($_POST)) {
    $_SESSION["page_status"] = ["alert-danger", "Invaid Request"];
    Header("Location: /admin/pages/index.php");
    exit();
}

$newpage = new Page;
$newpage->addNewPage($_POST, $conn);
exit();
