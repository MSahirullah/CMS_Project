<?php
session_start();

$title = 'Home | CMS';
include 'layout.php';
include 'services/pages/navPages.php';
?>

<body>
    <div id="loader" class="d-none"></div>
    <div class="container">
        <nav class="navbar navbar-expand-sm">
            <div class="container-fluid">
                <a class="navbar-brand" href="/index.php">
                    CMS
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mynavbar">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="mynavbar">
                    <ul class="navbar-nav me-auto d-flex flex-wrap">
                        <?php foreach ($pages as $page) {
                            echo '<li class="nav-item"> <span class="nav-link page-url" data-url="' . $page["url"] . '" > ' . $page["title"] . ' </span></li>';
                        } ?>
                    </ul>
                </div>
                <a href="services/auth/users/userLogout.php" class="nav-link"><?php echo $_SESSION['user'] ?> (logout <i class="fa fa-sign-out" aria-hidden="true"></i>)</a>

            </div>
        </nav>
        <hr class="mt-0">
        <div class="row justify-content-center pt-5" id="welcomeContent">
            <div class="card col-md-8 bg-secondary">
                <div class="card-body text-center text-white">
                    Welcome to Content Management System (CMS)
                </div>
            </div>
        </div>
        <div id="pageContent" class="d-none">
            <div id="pageTitle">
            </div>
            <hr>
            <div class="row  m-0 ">
                <div class="col-md-12 p-0">
                    <img src="#" class="img-fluid rounded" alt="Responsive image" style="max-height:245px" width="100%" id="pageTumbnail">
                </div>
            </div>
            <div id="pageDesc" class="rounded">
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {

            $('.page-url').on('click', function() {

                $("body").css("opacity", "0.5");
                $("#loader").removeClass("d-none");

                $(".page-url").each(function() {
                    $(this).css("font-weight", 400);
                });
                $(this).css("font-weight", 700);
                $.ajax({
                    type: 'post',
                    url: '/services/pages/getPageContent.php',
                    data: {
                        'url': $(this).attr('data-url'),
                    },
                    success: function(data) {
                        page = JSON.parse((data));
                        if (page.pageData.title) {
                            $("body").css("opacity", "1");
                            $("#loader").addClass("d-none");

                            $("#welcomeContent").addClass("d-none");
                            $("#pageContent").removeClass('d-none');

                            $("#pageTitle").text(page.pageData.title);
                            $("#pageTumbnail").attr("src", page.uploadedimage);
                            $("#pageTumbnail").attr("alt", page.pageData.title);
                            $("#pageDesc").html(page.pageData.description);
                        }
                    }
                });
            });
        });
    </script>
</body>