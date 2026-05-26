<?php

include("../../conexion.php");

$data = json_decode(file_get_contents("php://input"), true);

$tipo = $data["tipo"];
$nombre = $data["nombre"];
$descripcion = $data["descripcion"];
$monto = $data["monto"];
$porcentaje = $data["porcentaje"];

$sql = "INSERT INTO servicios_productos(nombre,descripcion,monto,tipo,porcentaje,estado)
        VALUES('$nombre','$descripcion','$monto','$tipo','$porcentaje',1)";

if(mysqli_query($conn, $sql)){
    echo 1;
}else{
    echo mysqli_error($conn);
}