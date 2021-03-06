<?php
$title = "Admin Login | CMS";
include '../layout.php';
include 'include/header.php';
//Check Admin logged in
if (isset($_SESSION["admin"]) && $_SESSION["admin"]) {
    Header("Location: /admin/dashboard.php");
    exit();
}

?>

<body>
    <div class="row justify-content-center mx-0" style="margin-top:6rem">
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-header text-center">
                    <h5 class="card-title pt-1">Content Management System</h5>
                    <h6 class="card-title">Admin Login</h6>
                </div>
                <div class="card-body m-3">
                    <form action="/services/auth/admin/adminLogin.php" method="POST">
                        <?php
                        if (isset($_SESSION["login_status"]) && $_SESSION["login_status"]) {
                            echo '<div class="alert ' . $_SESSION["login_status"][0] . ' px-2 py-1" role="alert"> ' . $_SESSION["login_status"][1] . '</div>';
                            unset($_SESSION["login_status"]);
                        }
                        ?>
                        <div class="row mb-3">
                            <div class="col-lg-12 ">
                                <div class="form-group">
                                    <label class="mb-2" for="username">Username </label>
                                    <input type="text" class="form-control" placeholder="Username" name="username" id="username" onkeypress="return /[a-z0-9]/i.test(event.key)" autofocus required maxlength="100">
                                </div>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-lg-12 ">
                                <div class="form-group">
                                    <label class="mb-2" for="password">Password </label>
                                    <input type="password" class="form-control" placeholder="Password" name="password" id="password" required maxlength="100">
                                </div>
                            </div>
                        </div>
                        <div style="text-align:right;">
                            <input class="btn btn-primary px-4" type="submit" value="Sign In">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="footer">
        <a href="/login.php">
            Login as User
        </a>
    </div>
</body>