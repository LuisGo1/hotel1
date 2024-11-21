<?php

$host = "hoteldb.czikeku485po.us-east-2.rds.amazonaws.com";
$user = "admin";
$password = "Luis2020.";
$database = "hoteldb2";


$conexion = mysqli_connect($host, $user, $password, $database);
if (!$conexion) {
    echo "No se realizo la conexion a la basa de datos, el error fue:" .
        mysqli_connect_error();
}


?>