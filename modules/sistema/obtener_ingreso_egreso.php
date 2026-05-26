<?php
include("../../conexion.php");
session_start();

if (!isset($_SESSION['usuario'])) {
    echo json_encode([]);
    exit();
}

$fecha = $_GET['fecha'];
$id_usuario = $_SESSION['id'];

$sql = "SELECT sd.*, sp.nombre servicio_nombre
        FROM servicios s
        INNER JOIN servicio_detalle sd ON s.id = sd.id
        INNER JOIN servicios_productos sp ON sp.id = sd.servicio
        WHERE s.fecha = ? AND sd.id_usuario = ?
        AND sd.tipo_servicio = 'i'
        UNION 
        SELECT sd.*, sd.servicio servicio_nombre
        FROM servicios s
        INNER JOIN servicio_detalle sd ON s.id = sd.id
        WHERE s.fecha = ? AND sd.id_usuario = ?
        AND sd.tipo_servicio = 'e'
        ORDER BY id_detalle DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("sisi", $fecha, $id_usuario, $fecha, $id_usuario);
$stmt->execute();

$result = $stmt->get_result();

$ingresos = [];
$egresos = [];

while ($row = $result->fetch_assoc()) {
    if ($row['tipo_servicio'] == 'i') {
        $ingresos[] = $row;
    } else {
        $egresos[] = $row;
    }
}

$stmt = $conn->prepare("SELECT se.bloqueo, sd.tipo_servicio, sd.tipo_pago, SUM(monto) monto_grupo 
                        FROM servicios se, servicio_detalle sd 
                        WHERE se.id = sd.id AND fecha = ? AND sd.id_usuario = ?
                        GROUP BY se.bloqueo, sd.tipo_servicio, sd.tipo_pago;");
$stmt->bind_param("si", $fecha, $id_usuario);
$stmt->execute();

$result = $stmt->get_result();

$totales_ingresos = [];
$totales_egresos = [];
$bloqueo = 0;

while ($row = $result->fetch_assoc()) {
    if ($row['tipo_servicio'] == 'i') {
        $totales_ingresos[] = $row;
    } else {
        $totales_egresos[] = $row;
    }

    $bloqueo = $row['bloqueo'];
}

echo json_encode([
    "ingresos" => $ingresos,
    "egresos" => $egresos,
    "totales_ingresos" => $totales_ingresos,
    "totales_egresos" => $totales_egresos,
    "bloqueo" => $bloqueo
]);

$conn->close();
