<?php
include("../../conexion.php");
session_start();

if (!isset($_SESSION['usuario']) || $_SESSION['id'] != 1) {
    header("Location: ../../index.php");
    exit();
}

$active = "usuarios";
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Usuarios</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <link rel="stylesheet" href="../../css/sistema.css">
    <style>
        body {
            background: #f5f5f5;
        }

        .card {
            border-radius: 15px;
        }

        .required {
            color: red;
        }
    </style>
</head>

<body>

    <?php require_once('../../navbar.php'); ?>

    <div class="container mt-4">

        <div class="card shadow">
            <div class="card-header text-white" style="background-color: #ca2f96;">
                <h4>Usuarios del Sistema</h4>
            </div>

            <div class="card-body">
                <form id="formServicio">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Usuario <span class="required">*</span></label>
                            <input type="text" id="usuario" class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Password <span class="required">*</span></label>
                            <input type="password" id="password" class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Nombre <span class="required">*</span></label>
                            <input type="text" id="nombre" class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Rol <span class="required">*</span></label>
                            <select id="rol" class="form-control">
                                <option value="0">Seleccione</option>
                                <option value="1">Administrador</option>
                                <option value="2">Asistente</option>
                                <option value="3">Trabajador Porcentaje</option>
                                <option value="4">Trabajador Sueldo</option>
                            </select>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary mt-3">
                        Guardar
                    </button>
                </form>
            </div>
        </div>

        <div class="card shadow mt-4">
            <div class="card-body">

                <div id="contenedorTabla"></div>

            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            listarInformacion();
        });

        function listarInformacion() {
            fetch("listar_usuario.php")
                .then(res => res.text())
                .then(data => {
                    document.getElementById("contenedorTabla").innerHTML = data;
                    $('#tablaServicios').DataTable({
                        responsive: true,
                        destroy: true
                    });
                });
        }

        function eliminarRegistro(id) {
            Swal.fire({
                title: 'Cambiar estado?',
                text: 'Se cambiará de estado a activo/inactivo',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Modificar'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch("eliminar_usuario.php", {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json"
                            },
                            body: JSON.stringify({
                                id
                            })
                        })
                        .then(res => res.text())
                        .then(data => {
                            if (data == "1") {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Eliminado'
                                });
                                listarInformacion();
                            }
                        });
                }
            });
        }

        document.getElementById("formServicio")
            .addEventListener("submit", function(e) {

                e.preventDefault();

                const usuario = document.getElementById("usuario").value;
                const nombre = document.getElementById("nombre").value.trim();
                const password = document.getElementById("password").value;
                const rol = document.getElementById("rol").value;

                if (!usuario || !nombre || !password || rol == 0) {

                    Swal.fire({
                        icon: 'warning',
                        title: 'Campos requeridos',
                        text: 'Todos los campos son obligatorios'
                    });

                    return;
                }

                const payload = {
                    usuario,
                    nombre,
                    password,
                    rol
                };

                fetch("guardar_usuario.php", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json"
                        },
                        body: JSON.stringify(payload)
                    })
                    .then(res => res.text())
                    .then(data => {

                        if (data == "1") {

                            Swal.fire({
                                icon: 'success',
                                title: 'Guardado',
                                text: 'Registro guardado correctamente'
                            });

                            document.getElementById("formServicio").reset();

                            listarInformacion();

                        } else {

                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: data
                            });
                        }
                    });

            });
    </script>

</html>