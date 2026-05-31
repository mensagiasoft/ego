let chart = null;

document.addEventListener("DOMContentLoaded", function () {
    cargarAnios();
    cargarTrabajadores();

    const hoy =
            new Date();

        document.getElementById(
            "mes"
        ).value =
            hoy.getMonth() + 1;

        cargarReporte();

});

function cargarAnios() {
    const anio = new Date().getFullYear();
    let html = "";

    for (let i = anio; i >= anio - 5; i--) {
        html += `<option value="${i}">${i}</option>`;
    }

    document.getElementById("anio").innerHTML = html;
}

function cargarTrabajadores() {
    fetch("tab1_obtener_trabajadores.php")
        .then(r => r.json())
        .then(data => {
            let html = `<option value="0">Todos</option>`;

            data.forEach(el => {
                html += `<option value="${el.id}">${el.usuario}</option>`;
            });

            document.getElementById("trabajador").innerHTML = html;
        })
        .catch(error => {
            console.error(error);
        });
}

document.getElementById(
    "anio"
)?.addEventListener(
    "change",
    cargarReporte
);

document.getElementById(
    "mes"
)?.addEventListener(
    "change",
    cargarReporte
);

document.getElementById(
    "trabajador"
)?.addEventListener(
    "change",
    cargarReporte
);

function cargarReporte() {

    const anio =
        document.getElementById(
            "anio"
        ).value;

    const mes =
        document.getElementById(
            "mes"
        ).value;

    const trabajador =
        document.getElementById(
            "trabajador"
        ).value;

    fetch(
        `tab1_obtener_reporte.php?anio=${anio}&mes=${mes}&trabajador=${trabajador}`
    )
    .then(r => r.json())
    .then(data => {
        const tbody =
            document.getElementById(
                "tablaReporteBody"
            );

        tbody.innerHTML = "";

        // INGRESOS
        let ingresoYape = 0;
        let ingresoPlin = 0;
        let ingresoEfectivo = 0;
        let ingresoTarjeta = 0;

        // EGRESOS
        let egresoYape = 0;
        let egresoPlin = 0;
        let egresoEfectivo = 0;
        let egresoTarjeta = 0;

        if (!data.length) {

            tbody.innerHTML = `
                <tr>
                    <td colspan="8" class="text-center">
                        No hay registros
                    </td>
                </tr>
            `;

            limpiarTotales();

            return;
        }

        data.forEach(item => {

            let badgeTipo =
                item.tipo_servicio === "i"
                ? `<span class="badge bg-success">
                        Ingreso
                   </span>`
                : `<span class="badge bg-danger">
                        Egreso
                   </span>`;

            let yape = "-";
            let plin = "-";
            let efectivo = "-";
            let tarjeta = "-";

            const montoNumero =
                parseFloat(item.monto);

            const monto =
                `S/. ${montoNumero.toFixed(2)}`;

            // Pintar columnas
            switch(item.tipo_pago) {

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

                switch(item.tipo_pago) {

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

            } else {

                switch(item.tipo_pago) {

                    case "y":
                        egresoYape += montoNumero;
                        break;

                    case "p":
                        egresoPlin += montoNumero;
                        break;

                    case "e":
                        egresoEfectivo += montoNumero;
                        break;

                    case "t":
                        egresoTarjeta += montoNumero;
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

                    <td>
                        ${badgeTipo}
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
        const netoYape =
            ingresoYape - egresoYape;

        const netoPlin =
            ingresoPlin - egresoPlin;

        const netoEfectivo =
            ingresoEfectivo - egresoEfectivo;

        const netoTarjeta =
            ingresoTarjeta - egresoTarjeta;

        const totalNeto =
            netoYape +
            netoPlin +
            netoEfectivo +
            netoTarjeta;

        // PINTAR INGRESOS
        pintarMonto(
            "ingresoYape",
            ingresoYape
        );

        pintarMonto(
            "ingresoPlin",
            ingresoPlin
        );

        pintarMonto(
            "ingresoEfectivo",
            ingresoEfectivo
        );

        pintarMonto(
            "ingresoTarjeta",
            ingresoTarjeta
        );

        // PINTAR EGRESOS
        pintarMonto(
            "egresoYape",
            egresoYape
        );

        pintarMonto(
            "egresoPlin",
            egresoPlin
        );

        pintarMonto(
            "egresoEfectivo",
            egresoEfectivo
        );

        pintarMonto(
            "egresoTarjeta",
            egresoTarjeta
        );

        // PINTAR NETOS
        pintarMonto(
            "netoYape",
            netoYape
        );

        pintarMonto(
            "netoPlin",
            netoPlin
        );

        pintarMonto(
            "netoEfectivo",
            netoEfectivo
        );

        pintarMonto(
            "netoTarjeta",
            netoTarjeta
        );

        pintarMonto(
            "totalNeto",
            totalNeto
        );
    })
    .catch(console.error);
}

function pintarMonto(id, monto) {

    document.getElementById(
        id
    ).innerText =
        `S/. ${monto.toFixed(2)}`;
}

function limpiarTotales() {

    const ids = [

        "ingresoYape",
        "ingresoPlin",
        "ingresoEfectivo",
        "ingresoTarjeta",

        "egresoYape",
        "egresoPlin",
        "egresoEfectivo",
        "egresoTarjeta",

        "netoYape",
        "netoPlin",
        "netoEfectivo",
        "netoTarjeta",

        "totalNeto"
    ];

    ids.forEach(id => {

        document.getElementById(
            id
        ).innerText =
            "S/. 0.00";
    });
}