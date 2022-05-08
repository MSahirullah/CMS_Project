<?php

require_once('../../services/database.php');
include 'Page.php';

//Check Admin logged in
if (!(isset($_SESSION["admin"]) && $_SESSION["admin"])) {
    Header("Location: /admin/login.php");
    exit();
}

if (!(isset($_GET["url"]) && $_GET["url"])) {
    $pageDetails = "";
    $pageImage = "";
} else {
    $pageContent = new Page;
    $pageDetails = $pageContent->getPageContent($_GET['url'], $conn);
    $pageImage = $pageDetails['uploadedimage'];
    $pageDetails = $pageDetails['pageData'];
}
