<?php

require_once('../../services/database.php');

//Check Admin logged in
if (!(isset($_SESSION["admin"]) && $_SESSION["admin"])) {
    Header("Location: /admin/login.php");
    exit();
}

$query = "SELECT * FROM pages";
$pages = $conn->prepare($query);
$pages->execute();
$rowCount = $pages->rowCount();
