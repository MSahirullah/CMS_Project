<?php
$title = "Users | CMS Dashboard";
include '../../layout.php';
include '../include/header.php';
include '../../services/users/getAllUsers.php';

//Check Admin logged in
if (!(isset($_SESSION["admin"]) && $_SESSION["admin"])) {
    Header("Location: /admin/login.php");
    exit();
}
?>

<div class="container">
    <div>
        <h2 class="text-center"> Manage Users </h2>
    </div>

    <div class="row mt-4">
        <div class="col-md-12">
        </div>
        <?php
        if ($rowCount <= 0) {
            echo '<div class="alert alert-info  py-1" role="alert"> No Users Found!</div>';
        } else {
            $table = '<table class="table table-striped">
                        <thead>
                            <tr class="text-center">
                                <th> Username </th>
                                <th> First Name </th>
                                <th> Second Name </th>
                                <th> Email </th>
                                <th> Date Registered </th>
                            </tr>
                        </thead>
                        <tbody>';

            foreach ($users as $user) {
                $table = $table . '<tr>
                                    <td>' . $user['username'] . '</td>
                                    <td>' . $user['first_name'] . '</td>
                                    <td>' . $user['last_name'] . '</td>
                                    <td>' . $user['email'] . '</td>
                                    <td>' . date('Y-m-d', strtotime($user['created_at'])) . '</td>
                                    </tr>';
            }

            $table = $table . '</tbody></table>';
            echo $table;
        }
        ?>
    </div>
</div>