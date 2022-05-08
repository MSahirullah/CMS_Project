<?php
include 'Page.php';

require_once('services/database.php');

//Check user logged in
if (!isset($_SESSION["user"])) {
    header("Location: /login.php");
    exit();
}

$pagesDetails = new Page;
$pages = $pagesDetails->getPages($conn);
$rowCount = $pages->rowCount();
