<?php
    use sql\Connection;
    use web\Models\UserModel;
    include('../../Models/UserModel.php');
    include('../../../sql/Connection.php');

    if(!empty($_POST['email']) && !empty($_POST['password']))
    {
        //Email and password received, with content
       
        $email = $_POST['email'];
        $password = $_POST['password'];

        $user = new UserModel(Connection::getInstance());
        $data = $user->find($email); 

        if ($data && $password == $data["cli_senha"]) {
            $_SESSION['loggedUser'] = true;
            $_SESSION['userData'] = $data;

            header('Location: ../../../web/Views/home.php');
        } else {

            $incorrectLogin = true;

            require "../../Views/auth/login.php";
        }
    } else {

        //Null email and password, no content

        $emptyLogin = true;

        require "../../Views/auth/login.php";
    }