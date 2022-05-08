<?php

class User
{
    public function register($data, $conn)
    {
        $fname = isset($data['fname']) ? $data['fname'] : '';
        $lname = isset($data['lname']) ? $data['lname'] : '';
        $email = isset($data['email']) ? $data['email'] : '';
        $username = isset($data['username']) ? $data['username'] : '';
        $password_1 = isset($data['password_1']) ? $data['password_1'] : '';
        $password_2 =  isset($data['password_2']) ? $data['password_2'] : '';

        $_SESSION["register_details"] = ['fname' => $fname, 'lname' => $lname, 'email' => $email, 'username' => $username];

        if ($fname && $lname && $email && $username && $password_1 && $password_2) {

            //check password
            if ($password_1 != $password_2) {
                $_SESSION["register_status"] = ['alert-danger', "The password confirmation does not match."];
                Header("Location: /registration.php");
                exit();
            }

            if ($this->checkUsername($username, $conn)) {
                $req_user_sql = "INSERT INTO users(username, first_name, last_name, email, password ) VALUES(:username, :first_name, :last_name, :email, :password)";

                $statement = $conn->prepare($req_user_sql);

                $statement->execute([
                    'username' => $username,
                    'first_name' => $fname,
                    'last_name' => $lname,
                    'email' => $email,
                    'password' => $password_1,
                ]);
                unset($_SESSION["register_details"]);
                $_SESSION["login_status"] = ['alert-success', 'Registration success.'];
                Header("Location: /login.php");
                exit();
            } else {
                $_SESSION["register_status"] = ['alert-danger', "Username already exists."];
                Header("Location: /registration.php");
                exit();
            }
        } else {
            $_SESSION["register_status"] = ['alert-danger', "Some required information are missing. Please try again."];
            Header("Location: /registration.php");
            exit();
        }
    }

    public function getAllUsers($conn)
    {
        $query = "SELECT first_name, last_name, username, email, created_at FROM users ORDER BY id DESC";
        $users = $conn->prepare($query);
        $users->execute();
        return $users;
    }

    public function checkUsername($username, $conn)
    {
        $query = "SELECT * FROM users WHERE username=:username";
        $check_statement = $conn->prepare($query);
        $check_statement->execute(['username' => $username]);
        if ($check_statement->rowCount()) {
            return 0;
        }
        return 1;
    }
}
