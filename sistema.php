<?php
date_default_timezone_set("America/Lima");
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit();
}

$nombre = $_SESSION['nombre'];
$fecha = date("Y-m-d");
$active = "sistema";
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistema - Ego Salon</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="css/sistema.css">
</head>

<body>

    <?php require_once('navbar.php'); ?>

    <!-- CONTENIDO -->

    <div class="container mt-4">

        <!-- FECHA + CIERRE -->
        <div class="card-box mb-4">

            <div class="row align-items-end">

                <div class="col-lg-6 col-12">
                    <label class="form-label">Fecha</label>
                    <input type="date" id="fecha" class="form-control no-bloquear" value="<?php echo $fecha ?>">
                </div>

                <?php
                if ($_SESSION['id'] == 1) {
                ?>
                    <div class="col-lg-6 col-12 text-lg-end mt-3 mt-lg-0">
                        <button class="btn btn-danger" id="cerrarDia">
                            Cierre de Día
                        </button>
                    </div>
                <?php
                }
                ?>
            </div>

        </div>


        <div class="row">
            <!-- INGRESOS -->
            <div class="col-lg-6 col-12 mb-4">
                <div class="card-box">

                    <h4 class="mb-3" id="tituloIngresos">Ingresos</h4>

                    <div id="contenedorIngresos">

                        <div class="registro row g-2">

                            <div class="col-lg-3 col-12">
                                <select class="form-select servicio" id="servicio">
                                    <option value="0">Seleccione</option>
                                </select>
                            </div>

                            <div class="col-lg-2 col-6">
                                <input type="number" class="form-control monto" placeholder="S/." value="0.00" id="monto">
                            </div>

                            <div class="col-lg-3 col-6">
                                <select class="form-control tipo_pago">
                                    <option value="y">Yape</option>
                                    <option value="p">Plin</option>
                                    <option value="e">Efectivo</option>
                                </select>
                            </div>

                            <div class="col-lg-3 col-8">
                                <select class="form-control persona">
                                    <option value="1">Mujer</option>
                                    <option value="2">Hombre</option>
                                    <option value="0">Otro</option>
                                </select>
                            </div>

                            <!--<div class="col-lg-1 col-4">
                                <button class="btn btn-success agregarIngreso">+</button>
                            </div>-->

                        </div>

                    </div>

                    <button class="btn btn-primary mt-2" id="guardarIngresos">
                        Guardar Información
                    </button>

                    <!-- TABLA INGRESOS -->
                    <div class="table-responsive mt-4">
                        <table class="table table-striped table-bordered align-middle text-center">
                            <thead class="thead-custom">
                                <tr>
                                    <th>Servicio</th>
                                    <th>Monto</th>
                                    <th>Pago</th>
                                    <th>Persona</th>
                                    <th>Acción</th>
                                </tr>
                            </thead>
                            <tbody id="tablaIngresos">
                                <tr>
                                    <td colspan="5">Sin información</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>

            <!-- EGRESOS -->
            <div class="col-lg-6 col-12">
                <div class="card-box">

                    <h4 class="mb-3" id="tituloEgresos">Egresos</h4>

                    <div id="contenedorEgresos">

                        <div class="registro row g-2">

                            <div class="col-lg-4 col-12">
                                <input type="text" class="form-control servicio" placeholder="Egreso">
                            </div>
                            <div class="col-lg-3 col-6">
                                <input type="number" class="form-control monto" id="montoEgreso" placeholder="Monto">
                            </div>
                            <div class="col-lg-3 col-5">
                                <select class="form-control tipo_pago">
                                    <option value="e">Efectivo</option>
                                    <option value="y">Yape</option>
                                    <option value="p">Plin</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <button class="btn btn-primary mt-2" id="guardarEgresos">
                        Guardar Información
                    </button>

                    <!-- TABLA EGRESOS -->
                    <div class="table-responsive mt-4">
                        <table class="table table-striped table-bordered align-middle text-center">
                            <thead class="thead-custom">
                                <tr>
                                    <th>Concepto</th>
                                    <th>Monto</th>
                                    <th>Pago</th>
                                    <th>Acción</th>
                                </tr>
                            </thead>
                            <tbody id="tablaEgresos">
                                <tr>
                                    <td colspan="4">Sin información</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/sistema.js"></script>

</body>

</html>