<?php 

    session_start();

    require 'autoload.php';
    
    require 'config/createCity.php';
    require 'config/createRestaurant.php';
    require 'config/createSight.php';
    require 'config/createAccommodation.php';
    require 'config/createSuperUser.php';
    require 'auth.php';
    require 'web/Views/home.php';
?>