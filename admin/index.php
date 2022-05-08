<?php
session_start();

if (isset($_SESSION["admin"]) && $_SESSION["admin"]) {
    Header("Location:dashboard.php");
} else {
    Header("Location:login.php");
}
