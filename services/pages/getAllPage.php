<?php

require_once('../../services/database.php');
include 'Page.php';

//Check Admin logged in
if (!(isset($_SESSION["admin"]) && $_SESSION["admin"])) {
    Header("Location: /admin/login.php");
    exit();
}

$pagesDetails = new Page;
$pages = $pagesDetails->getAllPages($conn);
$rowCount = $pages->rowCount();
