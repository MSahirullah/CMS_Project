<?php

class Auth
{
    public function userLogin($cred, $conn)
    {
        if (isset($cred['username']) && isset($cred['password'])) {
            $username = $cred['username'];
            $password = $cred['password'];

            $query = "SELECT * FROM users WHERE username=:username AND password=:password";
            $statement = $conn->prepare($query);
            $statement->execute(
                array(
                    'username' => $cred["username"],
                    'password' => $cred["password"]
                )
            );
            $count = $statement->rowCount();

            if ($count > 0) {
                $_SESSION["user"] = $cred["username"];
                header("Location: /home.php");
                exit();
            }
        }
        $_SESSION["login_status"] = ['alert-danger', 'Username or Password is incorrect'];
        header("Location: /login.php");
        exit();
    }

    public function adminLogin($cred, $conn)
    {
        if (isset($cred['username']) && isset($cred['password'])) {
            $username = $cred['username'];
            $password = $cred['password'];

            $query = "SELECT * FROM admins WHERE username=:username AND password=:password";
            $statement = $conn->prepare($query);
            $statement->execute(
                array(
                    'username' => $cred["username"],
                    'password' => $cred["password"]
                )
            );
            $count = $statement->rowCount();

            if ($count > 0) {
                $_SESSION["admin"] = $cred["username"];
                header("Location: /admin/dashboard.php");
                exit();
            }
        }
        $_SESSION["login_status"] = ['alert-danger', 'Username or Password is incorrect'];
        header("Location: /admin/login.php");
        exit();
    }

    public function logout($person)
    {
        session_start();
        unset($_SESSION);
        session_destroy();

        if ($person == 'admin') {
            header("Location: /admin/login.php");
        } else {
            header("Location: /login.php");
        }
    }
}
