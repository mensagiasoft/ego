<?php

include("../../conexion.php");

$data = json_decode(file_get_contents("php://input"), true);

$usuario = $data["usuario"];
$nombre = $data["nombre"];
$password = md5($data["password"]);
$rol = $data["rol"];

$sql = "INSERT INTO usuarios (usuario, password, nombre, estado, rol)
        VALUES('$usuario','$password', '$nombre', 1, $rol)";

if(mysqli_query($conn, $sql)){
    echo 1;
}else{
    echo mysqli_error($conn);
}