<?php

include("../../conexion.php");
header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"), true);

$fecha = $data["fecha"];


$sql = "SELECT * FROM servicios WHERE fecha='$fecha'";
$res = $conn->query($sql);

if ($res->num_rows == 0) {

    $conn->query("INSERT INTO servicios(fecha,bloqueo) VALUES('$fecha',1)");

    echo json_encode([
        "status" => "cerrado"
    ]);
} else {

    $conn->query("UPDATE servicios SET bloqueo=1 WHERE fecha='$fecha'");

    echo json_encode([
        "status" => "cerrado"
    ]);
}
