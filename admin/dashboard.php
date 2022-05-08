<?php
$title = "Dashboard | CMS";
include '../layout.php';
include 'include/header.php';

//Check Admin logged in
if (!(isset($_SESSION["admin"]) && $_SESSION["admin"])) {
    Header("Location: /admin/login.php");
    exit();
}

?>

<body>
    <div class="container">
        <div>
            <h2 class="text-center"> Admin Dashboard </h2>
        </div>
    </div>
</body>