document.addEventListener("DOMContentLoaded", function () {
    cargarAniosTab2();
    cargarTrabajadoresTab2();

    const hoy = new Date();
    document.getElementById("mesTab2").value = hoy.getMonth() + 1;

    cargarReporteTab2();
});

function cargarAniosTab2() {
    const anio = new Date().getFullYear();
    let html = "";

    for (let i = anio; i >= anio - 5; i--) {
        html += `<option value="${i}">${i}</option>`;
    }

    document.getElementById("anioTab2").innerHTML = html;
}

function cargarTrabajadoresTab2() {
    fetch("tab1_obtener_trabajadores.php")
        .then(r => r.json())
        .then(data => {
            let html = `<option value="0">Todos</option>`;

            data.forEach(el => {
                html += `<option value="${el.id}">${el.usuario}</option>`;
            });

            document.getElementById("trabajadorTab2").innerHTML = html;
        })
        .catch(error => {
            console.error(error);
        });
}

document.getElementById("anioTab2")?.addEventListener("change", cargarReporteTab2);
document.getElementById("mesTab2")?.addEventListener("change", cargarReporteTab2);
document.getElementById("trabajadorTab2")?.addEventListener("change", cargarReporteTab2);

function cargarReporteTab2() {

    const anio =
        document.getElementById(
            "anioTab2"
        ).value;

    const mes =
        document.getElementById(
            "mesTab2"
        ).value;

    const trabajador =
        document.getElementById(
            "trabajadorTab2"
        ).value;

    fetch(
        `tab1_obtener_reporte.php?anio=${anio}&mes=${mes}&trabajador=${trabajador}`
    )
        .then(r => r.json())
        .then(data => {
            data = data.filter(
                item => parseInt(item.redes) === 1
            );

            const tbody =
                document.getElementById(
                    "tablaReporteBodyTab2"
                );

            tbody.innerHTML = "";

            // INGRESOS
            let ingresoYape = 0;
            let ingresoPlin = 0;
            let ingresoEfectivo = 0;
            let ingresoTarjeta = 0;

            if (!data.length) {

                tbody.innerHTML = `
                <tr>
                    <td colspan="8" class="text-center">
                        No hay registros
                    </td>
                </tr>
            `;

                limpiarTotalesTab2();

                return;
            }

            data.forEach(item => {

                let yape = "-";
                let plin = "-";
                let efectivo = "-";
                let tarjeta = "-";

                const montoNumero = parseFloat(item.monto);
                const monto = `S/. ${montoNumero.toFixed(2)}`;

                // Pintar columnas
                switch (item.tipo_pago) {

                    case "y":
                        yape = monto;
                        break;

                    case "p":
                        plin = monto;
                        break;

                    case "e":
                        efectivo = monto;
                        break;

                    case "t":
                        tarjeta = monto;
                        break;
                }

                // SUMATORIAS
                if (
                    item.tipo_servicio === "i"
                ) {

                    switch (item.tipo_pago) {

                        case "y":
                            ingresoYape += montoNumero;
                            break;

                        case "p":
                            ingresoPlin += montoNumero;
                            break;

                        case "e":
                            ingresoEfectivo += montoNumero;
                            break;

                        case "t":
                            ingresoTarjeta += montoNumero;
                            break;
                    }

                }

                tbody.innerHTML += `
                <tr>

                    <td>
                        ${item.fecha}
                    </td>

                    <td>
                        ${item.servicio}
                    </td>

                    <td>
                        ${item.usuario}
                    </td>

                    <td class="text-end">
                        ${yape}
                    </td>

                    <td class="text-end">
                        ${plin}
                    </td>

                    <td class="text-end">
                        ${efectivo}
                    </td>

                    <td class="text-end">
                        ${tarjeta}
                    </td>

                </tr>
            `;
            });

            // NETOS
            const total = ingresoYape + ingresoPlin + ingresoEfectivo + ingresoTarjeta;

            // PINTAR INGRESOS
            pintarMonto("ingresoYapeTab2", ingresoYape);
            pintarMonto("ingresoPlinTab2", ingresoPlin);
            pintarMonto("ingresoEfectivoTab2", ingresoEfectivo);
            pintarMonto("ingresoTarjetaTab2", ingresoTarjeta);
            pintarMonto("totalTab2", total);
        })
        .catch(console.error);
}

function limpiarTotalesTab2() {

    const ids = [
        "ingresoYapeTab2",
        "ingresoPlinTab2",
        "ingresoEfectivoTab2",
        "ingresoTarjetaTab2",
        "totalTab2"
    ];

    ids.forEach(id => {
        document.getElementById(id).innerText = "S/. 0.00";
    });
}
