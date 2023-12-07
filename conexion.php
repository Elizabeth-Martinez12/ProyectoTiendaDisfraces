<?php
$server = "localhost";
$user = "root";
$password = "";
$db = "TiendaDisfraces";

$conexion = new mysqli($server, $user,$password,$db);

if ($conexion->connect_errno){
    die("Conexion fallida". $conexion->connect_errno);
}else{
    echo "Conectado";
}
?>