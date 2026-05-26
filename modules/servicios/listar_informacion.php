<?php

include("../../conexion.php");

$sql = "SELECT * 
        FROM servicios_productos
        ORDER BY tipo DESC, nombre ASC;";

$query = mysqli_query($conn, $sql);

?>

<table id="tablaServicios"
    class="table table-bordered table-striped nowrap"
    style="width:100%">

    <thead class="table-dark">
        <tr>
            <th>Tipo</th>
            <th>Nombre</th>
            <th>Descripción</th>
            <th>Monto</th>
            <th>%</th>
            <th>Estado</th>
            <th>Acción</th>
        </tr>
    </thead>

    <tbody>
        <?php while ($row = mysqli_fetch_assoc($query)) { ?>
            <tr>
                <td><?= $row["nombre"] ?></td>
                <td>
                    <?= $row["tipo"] == "s"
                        ? "Servicio"
                        : "Producto" ?>
                </td>
                <td><?= $row["descripcion"] ?></td>
                <td>
                    <?= number_format(
                        $row["monto"],
                        2
                    ) ?>
                </td>
                <td><?= $row["porcentaje"] ?>%</td>
                <td>
                    <?= $row["estado"] == 1
                        ? "Activo"
                        : "<span style='color: red; font-weight: bold;'>Inactivo</span>" ?>
                </td>
                <td>
                    <button
                        class="btn rounded-circle estado-btn
                        <?= $row["estado"] == 1
                            ? "btn-success"
                            : "btn-danger" ?>"
                                    style="width:25px; height:25px; padding:0;"
                        onclick="eliminarRegistro(<?= $row['id'] ?>)">
                    </button>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>