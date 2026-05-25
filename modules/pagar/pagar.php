<?php
include("../../conexion.php");
session_start();

if (!isset($_SESSION['usuario']) || $_SESSION['id'] != 1) {
    header("Location: ../../index.php");
    exit();
}

$sql = "SELECT 
            s.fecha,
            u.usuario,
            SUM(sd.monto * sp.porcentaje / 100) AS total_pagar
        FROM servicios s
        INNER JOIN servicio_detalle sd ON s.id = sd.id
        INNER JOIN servicios_productos sp ON sd.servicio = sp.id
        INNER JOIN usuarios u ON sd.id_usuario = u.id
        WHERE sd.tipo_servicio = 'i'
        AND sd.id_usuario != 1
        GROUP BY s.fecha, u.usuario
        ORDER BY s.fecha DESC, u.usuario ASC";

$result = $conn->query($sql);

$active = "pagar";
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Reporte de Pago</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css" rel="stylesheet">

    <link rel="stylesheet" href="../../css/sistema.css">
</head>

<body>

    <?php require_once('../../navbar.php'); ?>

    <div class="container mt-4">
        <div class="card-box">

            <h4 class="mb-3">Reporte de Pago</h4>

            <table id="tabla" class="table table-striped table-bordered w-100">
                <thead class="thead-custom">
                    <tr>
                        <th>Fecha</th>
                        <th>Usuario</th>
                        <th>Total a Pagar</th>
                        <th>Detalle</th>
                    </tr>
                </thead>
                <tbody>

                    <?php while ($row = $result->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo $row['fecha']; ?></td>
                            <td><?php echo $row['usuario']; ?></td>
                            <td class="text-dark fw-bold">
                                S/. <?php echo number_format($row['total_pagar'], 2); ?>
                            </td>
                            <td>
                                <button class="btn btn-ver btn-sm ver-detalle"
                                    data-fecha="<?php echo $row['fecha']; ?>"
                                    data-usuario="<?php echo $row['usuario']; ?>">
                                    Ver
                                </button>
                            </td>
                        </tr>
                    <?php } ?>

                </tbody>
            </table>

        </div>
    </div>

    <!-- JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#tabla').DataTable({
                responsive: true,
                order: [
                    [0, 'desc']
                ],
                pageLength: 10,
                language: {
                    url: "https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json"
                }
            });
        });
    </script>

    <script>
        $(document).on('click', '.ver-detalle', function() {

            let fecha = $(this).data('fecha');
            let usuario = $(this).data('usuario');

            $('#detalleModal').modal('show');
            $('#detalleContenido').html('<div class="text-center"><div class="spinner-border"></div></div>');

            $.ajax({
                url: 'detalle_pago.php',
                type: 'POST',
                data: {
                    fecha: fecha,
                    usuario: usuario
                },
                success: function(response) {
                    $('#detalleContenido').html(response);
                },
                error: function() {
                    $('#detalleContenido').html('<div class="alert alert-danger">Error al cargar el detalle</div>');
                }
            });

        });
    </script>

    <div class="modal fade" id="detalleModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-fullscreen-sm-down">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Detalle de Pago</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body" id="detalleContenido">
                    <div class="text-center">
                        <div class="spinner-border"></div>
                    </div>
                </div>

            </div>
        </div>
    </div>

</body>

</html>