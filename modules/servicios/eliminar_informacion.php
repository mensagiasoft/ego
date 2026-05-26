<?php

include("../../conexion.php");

$data = json_decode(file_get_contents("php://input"), true);

$id = $data["id"];

$sql = "UPDATE servicios_productos SET estado = IF(estado = 1, 0, 1) WHERE id = '$id'";

if(mysqli_query($conn, $sql)){
    echo 1;
}else{
    echo mysqli_error($conn);
}