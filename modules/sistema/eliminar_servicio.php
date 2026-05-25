<?php
header('Content-Type: application/json');
include("../../conexion.php");

$data = json_decode(file_get_contents("php://input"), true);

$id = $data["id"] ?? null;
$idDetalle = $data["id_detalle"] ?? null;

if (!$id || !$idDetalle) {
    echo json_encode([
        "success" => false,
        "message" => "Datos incompletos"
    ]);
    exit;
}

$sql = "DELETE FROM servicio_detalle
        WHERE id = ? AND id_detalle = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $id, $idDetalle);

if ($stmt->execute()) {
    echo json_encode([
        "success" => true
    ]);
} else {
    echo json_encode([
        "success" => false,
        "message" => "No se pudo eliminar"
    ]);
}