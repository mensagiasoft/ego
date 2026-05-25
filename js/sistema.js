let listaServicios = [];

document.addEventListener("DOMContentLoaded", function () {
    cargarServicios();
    cargarDatosNow();
});

document.getElementById("fecha").addEventListener("change", function () {
    cargarDatosNow();
});

document.getElementById("servicio").addEventListener("change", function () {
    let select = this;

    let monto =
        document.getElementById(
            "monto"
        );

    let selectedOption =
        select.options[
        select.selectedIndex
        ];

    let valorMonto =
        selectedOption.getAttribute(
            "data-monto"
        );

    monto.value = valorMonto
        ? parseFloat(
            valorMonto
        ).toFixed(2)
        : "0.00";
});

document.getElementById("monto").addEventListener("blur", function () {

    let valor =
        this.value
            .replace(",", ".")
            .trim();

    // si está vacío o inválido
    if (
        valor === "" ||
        isNaN(valor)
    ) {

        this.value = "0.00";
        return;
    }

    let numero =
        parseFloat(valor);

    // evitar negativos
    if (numero < 0) {
        numero = 0;
    }

    this.value =
        numero.toFixed(2);

});

document.getElementById("montoEgreso").addEventListener("blur", function () {

    let valor = this.value.replace(",", ".").trim();

    // si está vacío o inválido
    if (valor === "" || isNaN(valor)) {
        this.value = "0.00";
        return;
    }

    let numero = parseFloat(valor);

    // evitar negativos
    if (numero < 0) {
        numero = 0;
    }

    this.value = numero.toFixed(2);

});

document.getElementById("guardarIngresos").addEventListener("click", function () {

    let fecha = document.getElementById("fecha").value;
    let servicio = document.querySelector("#contenedorIngresos .servicio");
    let monto = document.querySelector("#contenedorIngresos .monto");
    let tipoPago = document.querySelector("#contenedorIngresos .tipo_pago");
    let persona = document.querySelector("#contenedorIngresos .persona");

    let hayError = false;
    let primerError = null;

    // limpiar errores previos
    [servicio, monto, tipoPago, persona].forEach(campo => {
        campo.classList.remove("is-invalid");
    });

    // VALIDAR SERVICIO
    if (servicio.value === "0" || servicio.value === "") {
        servicio.classList.add("is-invalid");

        hayError = true;

        if (!primerError) {
            primerError = servicio;
        }
    }

    // VALIDAR MONTO
    if (!monto.value || parseFloat(monto.value) <= 0) {
        monto.classList.add("is-invalid");

        hayError = true;

        if (!primerError) {
            primerError = monto;
        }
    }

    // VALIDAR TIPO PAGO
    if (!tipoPago.value) {
        tipoPago.classList.add("is-invalid");

        hayError = true;

        if (!primerError) {
            primerError = tipoPago;
        }
    }

    // VALIDAR PERSONA
    if (!persona.value) {
        persona.classList.add("is-invalid");

        hayError = true;

        if (!primerError) {
            primerError = persona;
        }
    }

    // DETENER SI HAY ERROR
    if (hayError) {
        Swal.fire({
            icon: "warning",
            title: "Falta información",
            text:
                "Completa todos los campos"
        });

        if (primerError) {
            primerError.focus();
        }

        return;
    }

    // DATOS A GUARDAR
    let payload = {
        fecha: fecha,
        tipoServicio: "i",
        registros: [{
            servicio: servicio.value,
            monto: monto.value,
            tipo_pago: tipoPago.value,
            persona: persona.value
        }]
    };

    // GUARDAR
    fetch("modules/sistema/guardar_informacion.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body:
            JSON.stringify(payload)
    }).then(res => res.text()).then(data => {
        // Reestablecer valores
        servicio.selectedIndex = 0;
        monto.value = "0.00";
        tipoPago.value = "y";
        persona.value = "1";

        Swal.fire({
            icon: "success",
            title: "Guardado",
            text:
                "Ingresos registrados"
        });

        // RECARGAR TABLA
        cargarDatosNow();

    }).catch(err => {
        console.error(err);

        Swal.fire({
            icon: "error",
            title: "Error",
            text: "No se pudo guardar"
        });
    });
});

document.getElementById("guardarEgresos").addEventListener("click", function () {

    let fecha = document.getElementById("fecha").value;
    let servicio = document.querySelector("#contenedorEgresos .servicio");
    let monto = document.querySelector("#contenedorEgresos .monto");
    let tipoPago = document.querySelector("#contenedorEgresos .tipo_pago");

    let hayError = false;
    let primerError = null;

    // limpiar errores previos
    [servicio, monto, tipoPago].forEach(campo => {
        campo.classList.remove("is-invalid");
    });

    // VALIDAR SERVICIO
    if (servicio.value === "0" || servicio.value === "") {
        servicio.classList.add("is-invalid");

        hayError = true;

        if (!primerError) {
            primerError = servicio;
        }
    }

    // VALIDAR MONTO
    if (!monto.value || parseFloat(monto.value) <= 0) {
        monto.classList.add("is-invalid");

        hayError = true;

        if (!primerError) {
            primerError = monto;
        }
    }

    // VALIDAR TIPO PAGO
    if (!tipoPago.value) {
        tipoPago.classList.add("is-invalid");

        hayError = true;

        if (!primerError) {
            primerError = tipoPago;
        }
    }

    // DETENER SI HAY ERROR
    if (hayError) {
        Swal.fire({
            icon: "warning",
            title: "Falta información",
            text:
                "Completa todos los campos"
        });

        if (primerError) {
            primerError.focus();
        }

        return;
    }

    // DATOS A GUARDAR
    let payload = {
        fecha: fecha,
        tipoServicio: "e",
        registros: [{
            servicio: servicio.value,
            monto: monto.value,
            tipo_pago: tipoPago.value
        }]
    };

    // GUARDAR
    fetch("modules/sistema/guardar_informacion.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body:
            JSON.stringify(payload)
    }).then(res => res.text()).then(data => {
        // Reestablecer valores
        servicio.value = "";
        monto.value = "0.00";
        tipoPago.value = "y";

        Swal.fire({
            icon: "success",
            title: "Guardado",
            text:
                "Ingresos registrados"
        });

        // RECARGAR TABLA
        cargarDatosNow();

    }).catch(err => {
        console.error(err);

        Swal.fire({
            icon: "error",
            title: "Error",
            text: "No se pudo guardar"
        });
    });
});

document.getElementById("cerrarDia").onclick = function () {

    let fecha = document.getElementById("fecha").value;

    Swal.fire({
        title: '¿Cerrar día?',
        text: 'No podrás editar más registros',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí cerrar'
    }).then((result) => {

        if (result.isConfirmed) {

            fetch("modules/sistema/cerrar_dia.php", {
                method: "POST",
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    fecha: fecha
                })
            })
                .then(r => r.json())
                .then(data => {
                    Swal.fire('Día cerrado', '', 'success').then(() => {
                        bloquearPantalla(true);
                    });
                })
                .catch(err => console.error(err));

        }

    })
        .catch(err => console.error(err));

}

function cargarServicios() {
    fetch("modules/sistema/listar_servicios.php")
        .then(res => res.json())
        .then(data => {
            listaServicios = data;

            const selects = document.querySelectorAll(".servicio");

            selects.forEach(select => {
                select.innerHTML =
                    '<option value="0" data-monto="0">Seleccione</option>';

                listaServicios.forEach(servicio => {

                    select.innerHTML += `
                        <option 
                            value="${servicio.id}" 
                            data-monto="${servicio.monto}">
                            ${servicio.nombre}
                        </option>
                    `;
                });
            });

        })
        .catch(err => console.error(err));
}

function cargarDatosNow() {
    let fecha = document.getElementById("fecha").value;

    fetch(`modules/sistema/obtener_ingreso_egreso.php?fecha=${fecha}`)
        .then(res => res.json())
        .then(data => {
            renderTablaIngresos(data.ingresos);
            renderTablaEgresos(data.egresos);
            calcularTotales(data.totales_ingresos, data.totales_egresos);
            bloquearPantalla(data.bloqueo);

        })
        .catch(err => console.error(err));
}

function renderTablaIngresos(lista) {

    let tbody = document.getElementById("tablaIngresos");
    tbody.innerHTML = "";

    if (!lista.length) {
        tbody.innerHTML = `
            <tr>
                <td colspan="5">
                    No hay registros
                </td>
            </tr>
        `;

        return;
    }

    lista.forEach(item => {
        let pago = "";

        switch (item.tipo_pago) {
            case "y":
                pago = '<span class="badge" style="background-color: purple">Yape</span>';
                break;
            case "p":
                pago = '<span class="badge bg-success">Plin</span>';
                break;
            default:
                pago = '<span class="badge bg-dark">Efectivo</span>';
        }

        let persona = item.persona == 1 ? "Mujer" : item.persona == 2 ? "Hombre" : "Otro";

        tbody.innerHTML += `
            <tr>
                <td>${item.servicio_nombre}</td>
                <td>S/. ${parseFloat(item.monto).toFixed(2)}</td>
                <td>${pago}</td>
                <td>${persona}</td>
                <td>
                    <button class="btn btn-sm btn-danger eliminarRegistro"
                            data-id="${item.id}"
                            data-id-detalle="${item.id_detalle}">
                        <i class="bi bi-trash"></i>
                    </button>
                </td>
            </tr>
        `;
    });
}

document.addEventListener("click", function (e) {

    const btn = e.target.closest(".eliminarRegistro");

    if (!btn) return;

    Swal.fire({
        icon: "warning",
        title: "¿Eliminar registro?",
        text: "Esta acción no se puede deshacer",
        showCancelButton: true,
        confirmButtonText: "Sí",
        cancelButtonText: "No"
    }).then(result => {

        if (!result.isConfirmed) return;

        const payload = {
            accion: "eliminar_servicio",
            id: btn.dataset.id,
            id_detalle: btn.dataset.idDetalle
        };

        fetch("modules/sistema/eliminar_servicio.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify(payload)
        }).then(res => res.text()).then(data => {
            try {
                data = JSON.parse(data);
            } catch {
                throw new Error("Respuesta inválida");
            }

            if (data.success) {

                btn.closest("tr").remove();

                const tbody = document.getElementById("tablaIngresos");

                if (!tbody.querySelector("tr")) {
                    tbody.innerHTML = `
                        <tr>
                            <td colspan="5">
                                No hay registros
                            </td>
                        </tr>
                    `;
                }

                Swal.fire({
                    icon: "success",
                    title: "Eliminado",
                    text: "Registro eliminado correctamente"
                });

                cargarDatosNow();

            } else {

                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: data.message || "No se pudo eliminar"
                });
            }

        }).catch(error => {
            console.error(error);

            Swal.fire({
                icon: "error",
                title: "Error",
                text: "No se pudo guardar"
            });
        });

    });
});

function renderTablaEgresos(lista) {

    let tbody = document.getElementById("tablaEgresos");
    tbody.innerHTML = "";

    if (!lista.length) {
        tbody.innerHTML = `
            <tr>
                <td colspan="4">
                    No hay registros
                </td>
            </tr>
        `;

        return;
    }

    lista.forEach(item => {
        let pago = "";

        switch (item.tipo_pago) {
            case "y":
                pago = '<span class="badge" style="background-color: purple">Yape</span>';
                break;
            case "p":
                pago = '<span class="badge bg-success">Plin</span>';
                break;
            default:
                pago = '<span class="badge bg-dark">Efectivo</span>';
        }

        tbody.innerHTML += `
            <tr>
                <td>${item.servicio_nombre}</td>
                <td>S/. ${parseFloat(item.monto).toFixed(2)}</td>
                <td>${pago}</td>
                <td>
                    <button class="btn btn-sm btn-danger eliminarRegistro"
                            data-id="${item.id}"
                            data-id-detalle="${item.id_detalle}">
                        <i class="bi bi-trash"></i>
                    </button>
                </td>
            </tr>
        `;
    });
}

function calcularTotales(registrosIngresos, registrosEgresos) {

    const registros = [...registrosIngresos, ...registrosEgresos];

    // Valores iniciales
    let ingresos = {
        y: 0,
        p: 0,
        e: 0
    };

    let egresos = {
        y: 0,
        p: 0,
        e: 0
    };

    // Si no hay registros
    if (!registros || registros.length === 0) {
        document.getElementById("tituloIngresos").innerText = "Ingresos (Yape S/. 0.00 | Plin S/. 0.00 | Efectivo S/. 0.00)";
        document.getElementById("tituloEgresos").innerText = "Egresos (Yape S/. 0.00 | Plin S/. 0.00 | Efectivo S/. 0.00)";

        return;
    }

    // recorrer registros
    registros.forEach(reg => {
        let monto = parseFloat(reg.monto_grupo) || 0;

        // INGRESOS
        if (reg.tipo_servicio === "i") {
            ingresos[reg.tipo_pago] += monto;
        }

        // EGRESOS
        if (reg.tipo_servicio === "e") {
            egresos[reg.tipo_pago] += monto;
        }
    });

    // pintar labels
    document.getElementById(
        "tituloIngresos"
    ).innerHTML =
        `Ingresos <p style="font-size: 16px;">Yape S/. ${ingresos.y.toFixed(2)} | Plin S/. ${ingresos.p.toFixed(2)} | Efectivo S/. ${ingresos.e.toFixed(2)}</p>`;

    document.getElementById(
        "tituloEgresos"
    ).innerHTML =
        `Egresos <p style="font-size: 16px;">Yape S/. ${egresos.y.toFixed(2)} | Plin S/. ${egresos.p.toFixed(2)} | Efectivo S/. ${egresos.e.toFixed(2)}</p>`;
}

function bloquearPantalla(bloquear) {

    if (bloquear) {
        document.querySelectorAll("input,select,button").forEach(el => {

            if (!el.classList.contains("no-bloquear")) {
                el.disabled = true;
            }
        });
    } else {
        document.querySelectorAll("input,select,button").forEach(el => {
            el.disabled = false;
        });
    }

}
