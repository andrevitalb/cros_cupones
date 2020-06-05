<?php
    include('connections.php');
    
    mysqli_set_charset ($connect, "utf8");
    date_default_timezone_set('America/Mexico_City');

    function getUsers(){
        global $resultUsers, $connect;

        $queryUsers = "Select usuarios_ID as ID, usuarios_nombre as Nombre, usuarios_correo as Correo, usuarios_telefono as Teléfono from usuarios order by usuarios_ID";
        $resultUsers = mysqli_query($connect, $queryUsers);
    }
?>