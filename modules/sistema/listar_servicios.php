<?php
include("../../conexion.php");

$sql = "SELECT id, nombre, monto 
        FROM servicios_productos 
        WHERE estado = 1 AND tipo = 's'
        ORDER BY nombre ASC";

$result = $conn->query($sql);

$datos = [];

while ($row = $result->fetch_assoc()) {
    $datos[] = $row;
}

echo json_encode($datos);