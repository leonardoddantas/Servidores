<?php
    use sql\Connection;
    use web\Models\UserModel;

    if(!empty($_POST['email']) && !empty($_POST['password']))
    {
        //Email and password received, with content
       
        $email = $_POST['email'];
        $password = $_POST['password'];

        $user = new UserModel(Connection::getInstance());
        $data = $user->find($email); 

        if ($data && password_verify($password, $data["cli_senha"])) {
            $_SESSION['loggedUser'] = true;
            $_SESSION['userData'] = $data;

            require "../../Views/home.php";
        } else {

            $incorrectLogin = true;

            require "../../Views/auth/login.php";
        }
    } else {

        //Null email and password, no content

        $emptyLogin = true;

        require "../../Views/auth/login.php";
    }