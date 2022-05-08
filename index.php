<?php
session_start();
if (isset($_SESSION["user"])) {
    Header("Location:home.php");
} else {
    Header("Location:login.php");
}
exit();
