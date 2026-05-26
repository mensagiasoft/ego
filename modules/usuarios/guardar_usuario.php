<?php

include("../../conexion.php");

$data = json_decode(file_get_contents("php://input"), true);

$usuario = $data["usuario"];
$nombre = $data["nombre"];
$password = md5($data["password"]);

$sql = "INSERT INTO usuarios (usuario, password, nombre, estado)
        VALUES('$usuario','$password', '$nombre', 1)";

if(mysqli_query($conn, $sql)){
    echo 1;
}else{
    echo mysqli_error($conn);
}