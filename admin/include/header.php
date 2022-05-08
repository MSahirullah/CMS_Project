<?php
session_start();
?>
<div class="container">
    <?php if (isset($_SESSION['admin']) && $_SESSION['admin']) { ?>
        <nav class="navbar navbar-expand-sm">
            <div class="container-fluid">
                <a class="navbar-brand" href="/admin/index.php">
                    CMS Admin
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mynavbar">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="mynavbar">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="/admin/pages/index.php">
                                <i class="fa-solid fa-newspaper"></i>
                                Pages
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/admin/users/index.php">
                                <i class="fa-solid fa-user-group"></i>
                                Users
                            </a>
                        </li>
                    </ul>
                    <form class="d-flex">
                        <a href="/services/auth/admin/adminLogout.php" class="nav-link"><?php echo $_SESSION['admin'] ?> (logout)</a>
                    </form>
                </div>
            </div>
        </nav>
        <hr class="mt-0">
    <?php } ?>
</div>`