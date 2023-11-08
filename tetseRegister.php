<?php
     use sql\Connection;
     include('../../../sql/Connection.php');

    if(!empty($_POST['name']) && !empty($_POST['city']) && !empty($_POST['state']) && !empty($_POST['phoneNumber']) && !empty($_POST['email']) && !empty($_POST['password'])) {

        //All the data of the registration form were received, with content

        $name = $_POST['name'];
        $city = $_POST['city'];
        $state = $_POST['state'];
        $phoneNumber = $_POST['phoneNumber'];
        $type = 'comum';
        $email = $_POST['email'];
        $password = $_POST['password'];

        list($username, $domain) = explode('@', $email);

        if (filter_var($email, FILTER_VALIDATE_EMAIL) && checkdnsrr($domain, 'MX')) {
            
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
            
            if($data) {
                require "../../Views/auth/login.php";
            } else {

                function save(string $userName, string $userCity, string $userState, string $userPhoneNumber, string $userType, string $userEmail, string $userPassword, $connection) : bool 
                {
                    $query = "INSERT INTO tb_clientes(cli_nome, cli_cidade, cli_estado, cli_telefone, cli_tipo, cli_email, cli_senha)"  . "values(:userName,:userCity,:userState,:userPhoneNumber,:userType,:userEmail,:userPassword)";
                    $stmt = $connection->prepare($query);
                    $stmt->bindValue(":userName", $userName);
                    $stmt->bindValue(":userCity", $userCity);
                    $stmt->bindValue(":userState", $userState);
                    $stmt->bindValue(":userPhoneNumber", $userPhoneNumber);
                    $stmt->bindValue(":userType", $userType);
                    $stmt->bindValue(":userEmail", $userEmail);
                    $stmt->bindValue(":userPassword", password_hash($userPassword, PASSWORD_ARGON2I));
                    $result = $stmt->execute();
                    return $result;
                }
                
                $ResultQueryExecution = save($name, $city, $state, $phoneNumber, $type, $email, $password, $connection);
                
                //The data was saved executed successfully
                $_SESSION['loggedUser'] = true;
    
                $data = find($email, $connection);
                $_SESSION['userData'] = $data;
    
                header('Location: ../../../web/Views/home.php');
            }   
        } else {
            $incorrectRegister = true;

            require "../../Views/auth/login.php";
        }
       
    } else {
        $emptyRegister = true;

        require "../../Views/auth/login.php";
    }
