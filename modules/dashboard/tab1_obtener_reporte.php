<?php

require "../../conexion.php";

header('Content-Type: application/json');

$anio = $_GET["anio"] ?? date("Y");
$mes = $_GET["mes"] ?? date("m");
$trabajador = ($_GET["trabajador"] == null) ? 0 : $_GET["trabajador"];
$whereTrabajador = "";

if ($trabajador != 0 && $trabajador != null) {
    $whereTrabajador = " AND sd.id_usuario = ? ";
}

$sql = "
SELECT
    s.fecha,
    CASE
        WHEN sd.servicio REGEXP '^[0-9]+$'
        THEN (SELECT nombre FROM servicios_productos WHERE id = sd.servicio)
        ELSE sd.servicio
    END AS servicio,
    sd.tipo_servicio,
    sd.tipo_pago,
    sd.monto,
    u.usuario
FROM servicios s
INNER JOIN servicio_detalle sd
    ON s.id = sd.id
INNER JOIN usuarios u
    ON u.id = sd.id_usuario
WHERE YEAR(
    STR_TO_DATE(
        s.fecha,
        '%Y-%m-%d'
    )
) = ?
AND MONTH(
    STR_TO_DATE(
        s.fecha,
        '%Y-%m-%d'
    )
) = ?
$whereTrabajador
ORDER BY s.fecha DESC";

$stmt = $conn->prepare($sql);

if ($trabajador != 0) {
    $stmt->bind_param("iii", $anio, $mes, $trabajador);
} else {
    $stmt->bind_param("ii", $anio, $mes);
}

$stmt->execute();

$result = $stmt->get_result();
$data = [];

while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode($data);