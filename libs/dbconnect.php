<?php
    //VPS
    //http://54.39.123.196/phpmyadmin/
    /*$servername = "54.39.123.196";
    $database = "crm_db";
    $username = "root";    
    $password = "casca123@DEVS";*/ 
    
    //Localhost
    $servername = "localhost";
    $database = "crm_db";
    $username = "root";    
    $password = "";   
    
    $con = new mysqli($servername, $username, $password, $database);

    // Checar conexão
    if ($con->connect_error) {
        die("Connection failed: " . $con->connect_error);
    }

    if (!$con) {
        die("Connection failed: ". mysqli_connect_error());
    }
    //echo "Conectado com sucesso!";
?>