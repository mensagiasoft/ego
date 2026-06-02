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
                            Ventas Mes
                        </button>
                    </li>

                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="tab2-tab" data-bs-toggle="tab" data-bs-target="#tab2" type="button" role="tab">
                            Ventas Internet
                        </button>
                    </li>
                </ul>
            </div>

            <div class="card-body">
                <!-- Contenido -->
                <div class="tab-content">
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
                                                    Ingresos - Egresos
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

                                            <!-- TOTAL BRUTO -->
                                            <tr class="table-primary fw-bold">

                                                <td colspan="4" class="text-end fs-5">
                                                    Total Bruto
                                                </td>

                                                <td colspan="4"
                                                    class="text-end fs-4"
                                                    id="totalBruto">

                                                    S/. 0.00

                                                </td>

                                            </tr>

                                            <!-- TOTAL NETO -->
                                            <tr class="table-dark fw-bold">

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

                    <div class="tab-pane fade" id="tab2" role="tabpanel">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body">
                                <!-- FILTROS -->
                                <div class="row g-3 mb-4">
                                    <div class="col-12 col-md-4">
                                        <label class="form-label">Año</label>
                                        <select id="anioTab2" class="form-select"></select>
                                    </div>

                                    <div class="col-12 col-md-4">
                                        <label class="form-label">
                                            Mes
                                        </label>

                                        <select id="mesTab2" class="form-select">
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
                                        <select id="trabajadorTab2" class="form-select"></select>
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
                                                <th class="text-end">Yape</th>
                                                <th class="text-end">Plin</th>
                                                <th class="text-end">Efectivo</th>
                                                <th class="text-end">Tarjeta</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tablaReporteBodyTab2">
                                            <tr>
                                                <td colspan="7">No hay registros</td>
                                            </tr>
                                        </tbody>
                                        <tfoot>

                                            <!-- INGRESOS -->
                                            <tr class="table-success fw-bold">

                                                <td colspan="3" class="text-end">
                                                    Subtotal Ingresos
                                                </td>

                                                <td class="text-end" id="ingresoYapeTab2">
                                                    S/. 0.00
                                                </td>

                                                <td class="text-end" id="ingresoPlinTab2">
                                                    S/. 0.00
                                                </td>

                                                <td class="text-end" id="ingresoEfectivoTab2">
                                                    S/. 0.00
                                                </td>

                                                <td class="text-end" id="ingresoTarjetaTab2">
                                                    S/. 0.00
                                                </td>

                                            </tr>

                                            <!-- TOTAL -->
                                            <tr class="table-dark fw-bold">

                                                <td colspan="3" class="text-end fs-5">
                                                    Total
                                                </td>

                                                <td colspan="4"
                                                    class="text-end fs-4"
                                                    id="totalTab2">

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
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../../js/dashboard_tab1.js"></script>
    <script src="../../js/dashboard_tab2.js"></script>
</body>

</html>