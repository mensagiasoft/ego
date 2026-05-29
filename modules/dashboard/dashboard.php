<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit();
}

$active = "dashboard";
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard - Ego Salon</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../css/sistema.css">
    <style>
        .thead-morado th {
            background-color: #ca2f96 !important;
            color: white !important;
        }
    </style>
</head>

<body>
    <?php require_once('../../navbar.php'); ?>
    <div class="container py-4">
        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <!-- Tabs -->
                <ul class="nav nav-tabs card-header-tabs" id="panelTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="tab1-tab" data-bs-toggle="tab" data-bs-target="#tab1" type="button" role="tab">
                            Ventas por mes
                        </button>
                    </li>

                    <!--<li class="nav-item" role="presentation">
                        <button
                            class="nav-link"
                            id="ventas-tab"
                            data-bs-toggle="tab"
                            data-bs-target="#ventas"
                            type="button"
                            role="tab">

                            Ventas
                        </button>
                    </li>-->
                </ul>
            </div>

            <div class="card-body">
                <!-- Contenido -->
                <div class="tab-content">
                    <div
                        class="tab-pane fade show active" id="tab1" role="tabpanel">
                        <div class="tab-pane fade show active" id="tab1" role="tabpanel">
                            <div class="card border-0 shadow-sm">
                                <div class="card-body">
                                    <!-- FILTROS -->
                                    <div class="row g-3 mb-4">
                                        <div class="col-12 col-md-4">
                                            <label class="form-label">Año</label>
                                            <select id="anio" class="form-select"></select>
                                        </div>

                                        <div class="col-12 col-md-4">
                                            <label class="form-label">
                                                Mes
                                            </label>

                                            <select id="mes" class="form-select">
                                                <option value="1">Enero</option>
                                                <option value="2">Febrero</option>
                                                <option value="3">Marzo</option>
                                                <option value="4">Abril</option>
                                                <option value="5">Mayo</option>
                                                <option value="6">Junio</option>
                                                <option value="7">Julio</option>
                                                <option value="8">Agosto</option>
                                                <option value="9">Septiembre</option>
                                                <option value="10">Octubre</option>
                                                <option value="11">Noviembre</option>
                                                <option value="12">Diciembre</option>
                                            </select>
                                        </div>

                                        <div class="col-12 col-md-4">
                                            <label class="form-label">Trabajador</label>
                                            <select id="trabajador" class="form-select"></select>
                                        </div>
                                    </div>

                                    <!-- TABLA -->
                                    <div class="table-responsive">
                                        <table class="table table-hover table-bordered align-middle">
                                            <thead class="thead-morado">
                                                <tr>
                                                    <th>Fecha</th>
                                                    <th>Servicio / Producto</th>
                                                    <th>Trabajador</th>
                                                    <th>Tipo</th>
                                                    <th class="text-end">Yape</th>
                                                    <th class="text-end">Plin</th>
                                                    <th class="text-end">Efectivo</th>
                                                    <th class="text-end">Tarjeta</th>
                                                </tr>
                                            </thead>
                                            <tbody id="tablaReporteBody">
                                                <tr>
                                                    <td colspan="8">No hay registros</td>
                                                </tr>
                                            </tbody>
                                            <tfoot>

                                                <!-- INGRESOS -->
                                                <tr class="table-success fw-bold">

                                                    <td colspan="4" class="text-end">
                                                        Subtotal Ingresos
                                                    </td>

                                                    <td class="text-end" id="ingresoYape">
                                                        S/. 0.00
                                                    </td>

                                                    <td class="text-end" id="ingresoPlin">
                                                        S/. 0.00
                                                    </td>

                                                    <td class="text-end" id="ingresoEfectivo">
                                                        S/. 0.00
                                                    </td>

                                                    <td class="text-end" id="ingresoTarjeta">
                                                        S/. 0.00
                                                    </td>

                                                </tr>

                                                <!-- EGRESOS -->
                                                <tr class="table-danger fw-bold">

                                                    <td colspan="4" class="text-end">
                                                        Subtotal Egresos
                                                    </td>

                                                    <td class="text-end" id="egresoYape">
                                                        S/. 0.00
                                                    </td>

                                                    <td class="text-end" id="egresoPlin">
                                                        S/. 0.00
                                                    </td>

                                                    <td class="text-end" id="egresoEfectivo">
                                                        S/. 0.00
                                                    </td>

                                                    <td class="text-end" id="egresoTarjeta">
                                                        S/. 0.00
                                                    </td>

                                                </tr>

                                                <!-- NETO -->
                                                <tr class="table-warning fw-bold">

                                                    <td colspan="4" class="text-end">
                                                        Neto (Ingresos - Egresos)
                                                    </td>

                                                    <td class="text-end" id="netoYape">
                                                        S/. 0.00
                                                    </td>

                                                    <td class="text-end" id="netoPlin">
                                                        S/. 0.00
                                                    </td>

                                                    <td class="text-end" id="netoEfectivo">
                                                        S/. 0.00
                                                    </td>

                                                    <td class="text-end" id="netoTarjeta">
                                                        S/. 0.00
                                                    </td>

                                                </tr>

                                                <!-- TOTAL -->
                                                <tr class="table-primary fw-bold">

                                                    <td colspan="4" class="text-end fs-5">
                                                        Total Neto
                                                    </td>

                                                    <td colspan="4"
                                                        class="text-end fs-4"
                                                        id="totalNeto">

                                                        S/. 0.00

                                                    </td>

                                                </tr>

                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div
                        class="tab-pane fade"
                        id="ventas"
                        role="tabpanel">

                        <h4>Ventas</h4>
                        <p>
                            Aquí puedes ver las ventas.
                        </p>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../../js/dashboard.js"></script>
</body>

</html>