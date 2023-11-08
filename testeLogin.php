<?php
    use sql\Connection;
    include('../../../sql/Connection.php');

    if(!empty($_POST['email']) && !empty($_POST['password']))
    {
        //Email and password received, with content
       
        $email = $_POST['email'];
        $password = $_POST['password'];

    
        $connection = Connection::getInstance();
        function find(string $emailUser, $connection) : Array | bool
        {
            $query = "SELECT * FROM tb_clientes WHERE cli_email=:emailUser";
            $stmt = $connection->prepare($query);
            $stmt->bindValue(":emailUser", $emailUser);
            $stmt->execute();
            return $stmt->fetch();
        }

        $data = find($email, $connection);

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
