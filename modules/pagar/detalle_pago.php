<?php
include("../../conexion.php");

$fecha = $_POST['fecha'];
$usuario = $_POST['usuario'];

$sql = "SELECT 
            sp.nombre,
            sd.monto,
            sp.porcentaje,
            (sd.monto * sp.porcentaje / 100) AS pago,
            ELT(FIELD(sd.tipo_pago, 'y','p','e'), 'Yape','Plin','Efectivo') AS tipo_pago
        FROM servicios s
        INNER JOIN servicio_detalle sd ON s.id = sd.id
        INNER JOIN servicios_productos sp ON sd.servicio = sp.id
        INNER JOIN usuarios u ON sd.id_usuario = u.id
        WHERE s.fecha = '$fecha'
        AND u.usuario = '$usuario'
        ORDER BY sd.tipo_pago DESC, sp.nombre ASC";

$result = $conn->query($sql);
$yape = 0;
$plin = 0;
$efectivo = 0;
?>

<div class="table-responsive">
    <table class="table table-bordered">
        <thead class="thead-custom">
            <tr>
                <th>Servicio</th>
                <th>Monto</th>
                <th>Pago</th>
            </tr>
        </thead>
        <tbody>

            <?php while ($row = $result->fetch_assoc()) {
                $yape += ($row['tipo_pago'] == 'Yape') ? $row['pago'] : 0;
                $plin += ($row['tipo_pago'] == 'Plin') ? $row['pago'] : 0;
                $efectivo += ($row['tipo_pago'] == 'Efectivo') ? $row['pago'] : 0;
            ?>
                <tr>
                    <td>
                        <?php echo $row['nombre']; ?>
                        <small class="fw-bold" style="color:black">
                            (<?php echo $row['tipo_pago']; ?>)
                        </small>
                    </td>
                    <td>S/. <?php echo number_format($row['monto'], 2); ?></td>
                    <td class="text-success">
                        S/. <?php echo number_format($row['pago'], 2); ?>
                        <small class="fw-bold" style="color:#c9a46a;">
                            (<?php echo $row['porcentaje']; ?>%)
                        </small>
                    </td>
                </tr>
            <?php } ?>

        </tbody>
    </table>
</div>
<div>
    <?php 
        if ($yape > 0) {
            echo "<b>Yape:</b> S/. " . number_format($yape, 2) . " ";
        }

        if ($plin > 0) {
            echo "<b>Plin:</b> S/. " . number_format($plin, 2) . " ";
        }

        if ($efectivo > 0) {
            echo "<b>Efectivo:</b> S/. " . number_format($efectivo, 2);
        }
    ?>
</div>

<style>
    .thead-custom th {
        background-color: #ca2f96 !important;
        color: white !important;
    }
</style>