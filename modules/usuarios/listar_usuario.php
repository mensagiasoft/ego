<?php

include("../../conexion.php");

$sql = "SELECT * 
        FROM usuarios
        ORDER BY id ASC";

$query = mysqli_query($conn, $sql);

?>

<table id="tablaServicios"
    class="table table-bordered table-striped nowrap"
    style="width:100%">

    <thead class="table-dark">
        <tr>
            <th>Usuario</th>
            <th>Password</th>
            <th>Nombre</th>
            <th>Rol</th>
            <th>Estado</th>
            <th>Acción</th>
        </tr>
    </thead>

    <tbody>
        <?php while ($row = mysqli_fetch_assoc($query)) { ?>
            <tr>
                <td><?= $row["usuario"] ?></td>
                <td><?= substr($row["password"], 0, 8) . "****" . substr($row["password"], -8) ?></td>
                <td><?= $row["nombre"] ?></td>
                <td><?= $row["rol"] == 1 ? "Administrador" : ($row["rol"] == 2 ? "Asistente" : ($row["rol"] == 3 ? "Porcentaje" : "Sueldo")) ?></td>
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