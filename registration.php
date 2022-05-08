<?php
session_start();
$title = 'New User Registration | CMS';
include 'layout.php';

//Check user logged in
if (isset($_SESSION["user"]) && $_SESSION["user"]) {
    Header("Location: /home.php");
    exit();
}
?>

<body>
    <div class="row justify-content-center mx-0" style="margin-top:7rem">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header text-center">
                    <h5 class="card-title pt-1">Content Management System</h5>
                    <h6 class="card-title">New User Registration</h6>
                </div>
                <div class="card-body m-3">
                    <form action="/services/auth/users/userRegister.php" method="POST" onsubmit="return validate()">
                        <?php if (isset($_SESSION["register_status"]) && $_SESSION["register_status"]) {
                            echo '<div class="alert ' . $_SESSION["register_status"][0] . ' px-2 py-1" role="alert"> ' . $_SESSION["register_status"][1] . '</div>';
                            unset($_SESSION["register_status"]);
                        } ?>
                        <div></div>
                        <div class="row mb-3">
                            <div class="col-lg-6 ">
                                <div class="form-group">
                                    <label class="mb-2" for="fname">First Name *</label>
                                    <input type="text" class="form-control" placeholder="First Name" name="fname" id="fname" onkeypress="return /[a-z]/i.test(event.key)" autofocus required maxlength="100" value="<?php echo isset($_SESSION["register_details"]) ? $_SESSION["register_details"]['fname'] : ''; ?>">
                                    <div id="fnameError" class="d-none inputError"></div>

                                </div>
                            </div>
                            <div class="col-lg-6 ">
                                <div class="form-group">
                                    <label class="mb-2" for="lname">Last Name *</label>
                                    <input type="text" class="form-control" placeholder="Last Name" name="lname" id="lname" onkeypress="return /[a-z]/i.test(event.key)" required maxlength="100" value="<?php echo isset($_SESSION["register_details"]) ? $_SESSION["register_details"]['lname'] : ''; ?>">
                                    <div id="lnameError" class="d-none inputError"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-lg-6 ">
                                <div class="form-group">
                                    <label class="mb-2" for="email"> Email Address *</label>
                                    <input type="email" class="form-control" placeholder="Email Address" name="email" id="email" required maxlength="100" value="<?php echo isset($_SESSION["register_details"]) ? $_SESSION["register_details"]['email'] : ''; ?>">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="mb-2" for="username"> Username *</label>
                                    <input type="text" class="form-control" placeholder="Username" name="username" id="username" onkeypress="return /[a-z0-9]/i.test(event.key)" required maxlength="100" value="<?php echo isset($_SESSION["register_details"]) ? $_SESSION["register_details"]['username'] : ''; ?>">
                                    <div id="usernameError" class="d-none inputError"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="mb-2" for="password_1"> Password *</label>
                                    <span onclick="showPasswordTip()" id="passwordInfo" class="password-info"><i class="fas fa-exclamation-circle"></i></span>
                                    <input type="password" class="form-control" placeholder="Password" name="password_1" id="password_1" required maxlength="100">
                                    <div id="passwordInfoMSG" class="d-none"></div>
                                    <div id="password_1Error" class="d-none inputError"></div>

                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="mb-2" for="password_2"> Confirm Password *</label>
                                    <input type="password" class="form-control" placeholder="Repeat Password" name="password_2" id="password_2" required maxlength="100">
                                    <div id="password_2Error" class="d-none inputError"></div>

                                </div>
                            </div>
                        </div>

                        <div style="text-align:right;">
                            <input class="btn btn-primary px-5" type="submit" value="Register Now" onClick="this.attr"> <br>
                        </div>
                        <div class="text-center">
                            <a href="/login.php">
                                Login
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php
    unset($_SESSION["register_details"]);
    ?>
    <script>
        function showPasswordTip() {
            if ($("#passwordInfoMSG").hasClass('d-none')) {
                $("#passwordInfoMSG").removeClass("d-none");
                $("#passwordInfoMSG").text("Password must be at least 8 characters with a combination of at least 1 uppercase letter, at least 1 number, lowercase letters and special characters.");
            } else {
                $("#passwordInfoMSG").addClass("d-none");
            }
        }

        function validate() {
            var valid = true;
            var nameReg = /^[A-Za-z]{3,}$/i;
            var usernameReg = /^[A-Za-z0-9]{6,}$/;
            var passwordReg = /^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/;

            $(".inputError").each(function() {
                $(this).addClass("d-none")
            });

            if (!nameReg.test($("#fname").val())) {
                $("#fnameError").removeClass("d-none");
                $("#fnameError").text("Invalid first name.");
                valid = false;
            }
            if (!nameReg.test($("#lname").val())) {
                $("#lnameError").removeClass("d-none");
                $("#lnameError").text("Invalid last name.");
                valid = false;
            }
            if (!usernameReg.test($("#username").val())) {
                $("#usernameError").removeClass("d-none");
                $("#usernameError").text("Invalid username.");
                valid = false;
            } else {
                $.ajax({
                    type: 'post',
                    url: '/services/auth/users/checkUsername.php',
                    data: {
                        'username': $("#username").val()
                    },
                    success: function(data) {
                        if (data != 1) {
                            $("#usernameError").removeClass("d-none");
                            $("#usernameError").text("Username already exists.");
                        }
                    }
                });
            }
            if (passwordReg.test($("#password_1").val())) {
                if ($("#password_1").val() != $("#password_2").val()) {
                    $("#password_2Error").removeClass("d-none");
                    $("#password_2Error").text("The password confirmation does not match.");
                    valid = false;
                }
            } else {
                $("#password_1Error").removeClass("d-none");
                $("#password_1Error").text("Invalid password format.");
                valid = false;
            }

            if (!valid) {
                return false;
            }
        }
    </script>
</body>