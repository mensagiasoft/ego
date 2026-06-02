<?php
include("../../conexion.php");
session_start();

if (!isset($_SESSION['usuario'])) {
    echo json_encode(["status" => "error", "msg" => "No autorizado"]);
    exit();
}

// Obtener JSON
$data = json_decode(file_get_contents("php://input"), true);

$fecha = $data['fecha'];
$tipo_servicio = $data['tipoServicio'];
$registros = $data['registros'];

$sql_cabecera = "SELECT * FROM servicios WHERE fecha='$fecha'";
$resul_cabecera = $conn->query($sql_cabecera);
$id_cabecera = 0;

if ($resul_cabecera->num_rows == 0) {
    $stmt_cabecera = $conn->prepare("INSERT INTO servicios (fecha, bloqueo) VALUES (?, ?)");
    $bloqueo = 0;
    $stmt_cabecera->bind_param("si", $fecha, $bloqueo);

    if (!$stmt_cabecera->execute()) {
        echo "Error stmt: " . $stmt_cabecera->error;
    }

    $stmt_cabecera->close();
    $id_cabecera = $conn->insert_id;
} else {
    $fila_cabecera = $resul_cabecera->fetch_assoc();
    $id_cabecera = $fila_cabecera["id"];
}

// Halla el id_detalle maximo de servicio_detalle
$sql_id_detalle = "SELECT IFNULL(MAX(id_detalle), 0) id_detalle FROM servicio_detalle WHERE id=$id_cabecera";
$resul_id_detalle = $conn->query($sql_id_detalle);
$fila_id_detalle = $resul_id_detalle->fetch_assoc();
$id_detalle = $fila_id_detalle["id_detalle"];

foreach ($registros as $item) {
    $id_detalle = $id_detalle + 1;
    $red = $item["redes"] != null ? $item["redes"] : 0;

    // Inserta registro
    $stmt_cabecera = $conn->prepare("INSERT INTO servicio_detalle (id, id_detalle, tipo_servicio, 
    servicio, monto, tipo_pago, persona, id_usuario, redes) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $stmt_cabecera->bind_param(
        "iissdssii",
        $id_cabecera,
        $id_detalle,
        $tipo_servicio,
        $item["servicio"],
        $item["monto"],
        $item["tipo_pago"],
        $item["persona"],
        $_SESSION['id'],
        $red
    );

    if (!$stmt_cabecera->execute()) {
        echo "Error stmt_cabecera: " . $stmt_cabecera->error;
    }

    $stmt_cabecera->close();
}

$conn->close();
