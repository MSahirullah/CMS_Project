<?php
$title = "Posts | CMS Dashbord";
include '../../layout.php';
include '../include/header.php';
include '../../services/pages/getAllPage.php';

//Check Admin logged in
if (!(isset($_SESSION["admin"]) && $_SESSION["admin"])) {
    Header("Location: /admin/login.php");
    exit();
}

?>
<div class="container">
    <div>
        <h2 class="text-center"> Manage Pages </h2>
    </div>
    <a class="btn btn-primary" href="/admin/pages/pageDetails.php">Add New Page</a>

    <div class="row mt-4 mx-0">
        <div class="col-md-12 px-0">
            <?php if (isset($_SESSION["page_status"]) && $_SESSION["page_status"]) {
                echo '<div class="py-1 alert ' . $_SESSION["page_status"][0] . '" role="alert"> ' . $_SESSION["page_status"][1] . '</div>';
                unset($_SESSION['page_status']);
            } ?>
        </div>
        <?php
        if ($rowCount <= 0) {
            echo '<div class="alert alert-info py-1" role="alert"> No Pages Found!</div>';
        } else {
            $table = '<table class="table table-striped">
                        <thead>
                            <tr class="text-center">
                                <th> Page </th>
                                <th> Status </th>
                                <th colspan="2"> Actions </th>
                            </tr>
                        </thead>
                        <tbody>';

            foreach ($pages as $page) {
                $status = $page["status"] == '1' ? 'Published' : 'Not Published';
                $table = $table . '<tr>
                                    <td> ' . $page["title"] . ' </td>
                                    <td class="text-center"> ' . $status . '</td>
                                    <td class="text-center">
                                        <a class="nav-link p-0" href="/admin/pages/pageDetails.php?url=' . $page['url'] . '">Edit</a>
                                    </td><td class="text-center">
                                        <span class="nav-link p-0 delete-link" data-title="' . $page["title"] . ' " data-url="' . $page["url"] . ' ">Delete</span>
                                    </td>
                                </tr>';
            }
            $table = $table . '</tbody></table>';
            echo $table;
        }
        ?>
    </div>
</div>
<script>
    $(".delete-link").on("click", function() {

        if (confirm("Do you want to delete " + $(this).attr("data-title") + " page?") == true) {
            $.ajax({
                type: 'post',
                url: '/services/pages/deletePage.php',
                data: {
                    'url': $(this).attr('data-url'),
                },
                success: function(data) {
                    if (data == '1') {
                        location.reload();
                    }
                }
            });
        }
    });
</script>
</body>