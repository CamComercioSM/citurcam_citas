let btnSi = document.getElementById("btnConfirmarCancelacion");
let btnNo = document.getElementById("btnCancelarAccion");
let btnConfirmarAccionFinal = document.getElementById("btnConfirmarAccionFinal");
let modalConfirmar = new bootstrap.Modal(document.getElementById('modalConfirmar'));
let path = window.location.pathname;
let citaHASH = path.split("/").pop().trim();
let datosCita = null;
let sedeID = '10';

let bloquePregunta = document.getElementById("bloquePregunta");
let bloqueResultado = document.getElementById("bloqueResultado");
let preguntaTexto = document.getElementById("preguntaTexto");

// Referencias a elementos del bloque de resultado
let icono = document.getElementById("iconResultado");
let titulo = document.getElementById("tituloResultado");
let textoIntro = document.getElementById("textoResultadoIntro");
let detalle = document.getElementById("infoCitaPregunta");

async function mostrarDatosCitaParaCancelar() {
    try {
        const res = await conectarseEndPoint('datosCitaPorHash', { citaHASH });
        if (!res || res.RESPUESTA !== "EXITO" || !res.DATOS) {
            mostrarResultado(
                false,
                null,
                "No encontramos una cita asociada a este enlace. Verifica el link o agenda una nueva cita."
            );
            btnSi.disabled = true;
            return;
        }

        datosCita = res.DATOS;
        if (datosCita.citaESTADOCITA === "SIN ASIGNAR") {
            mostrarResultado(
                false,
                null,
                "Esta cita no está disponible para cancelación. Verifica la información o agenda una nueva cita."
            );
            btnSi.disabled = true;
            return;
        }
        // Modo "información", aún NO cancelada
        if (icono) icono.className = "bi bi-info-circle-fill text-primary";
        if (titulo) titulo.textContent = "Información de tu cita";
        if (textoIntro) textoIntro.textContent = "Revisa los datos de tu cita antes de confirmar la cancelación.";
        if (detalle) detalle.classList.remove("d-none");

        const fechaHora = datosCita.citaFCHCITA;
        const soloHora = fechaHora.split(" ")[1].substring(0, 5);
        // Llenamos los datos
        document.getElementById("codigoCita").textContent = datosCita.citaID || "—";
        document.getElementById("fechaCita").textContent = datosCita.citaFCHCITA || "—";
        document.getElementById("horaCita").textContent = soloHora || "—";
        document.getElementById("moduloCita").textContent = datosCita.turnoTipoServicioTITULO || "—";
        document.getElementById("correoCita").textContent = datosCita.correoDIRECCION || "—";

    } catch (error) {
        console.error(error);
        preguntaTexto.textContent = "Ocurrió un error al cargar la información de la cita.";
        btnSi.disabled = true;
    }
}

async function mostrarResultado(exito, datosCita = {}, mensajeError = "") {
    if (bloquePregunta) bloquePregunta.classList.add("d-none");
    if (bloqueResultado) bloqueResultado.classList.remove("d-none");

    if (exito) {
        if (icono) icono.className = "bi bi-check-circle-fill text-success";
        if (titulo) titulo.textContent = "Tu cita ha sido cancelada";
        if (textoIntro) textoIntro.textContent = "La cancelación de tu cita se registró correctamente.";
        if (detalle) detalle.classList.remove("d-none");

        document.getElementById("codigoCita").textContent = datosCita.citaID || "—";
        document.getElementById("fechaCita").textContent = datosCita.citaFCHCITA || "—";
        document.getElementById("horaCita").textContent = datosCita.horaSeleccionada || "—";
        document.getElementById("moduloCita").textContent = datosCita.turnoTipoServicioTITULO || "—";
        document.getElementById("correoCita").textContent = datosCita.correoDIRECCION || "—";

    } else {
        if (icono) icono.className = "bi bi-x-circle-fill text-danger";
        if (titulo) titulo.textContent = "No pudimos cancelar tu cita";
        if (textoIntro) textoIntro.textContent = mensajeError || "Ocurrió un error al intentar cancelar tu cita.";
        if (detalle) detalle.classList.add("d-none");
    }
}

btnConfirmarAccionFinal.addEventListener("click", async function () {
    modalConfirmar.hide();
    const res = await conectarseEndPoint('cancelarCita', { citaHASH });
    datosCita = res.DATOS;
    try {
        if (res.RESPUESTA !== "EXITO") {
            let msg = (res && (res.MENSAJE || res.mensaje)) || "No fue posible cancelar tu cita.";
            await mostrarResultado(false, null, msg);
        } else {
            await mostrarResultado(true, datosCita);
        }

    } catch (err) {
        console.error(err);
        mostrarResultado(false, null, "Ocurrió un error de conexión. Intenta nuevamente.");
    }
});

btnSi.addEventListener("click", async function () {
    modalConfirmar.show();
});

btnNo.addEventListener("click", function () {
    window.location.href = "/";
});

document.addEventListener("DOMContentLoaded", function () {


    if (!citaHASH || citaHASH.toLowerCase() === "cancelaciones") {
        mostrarResultado(
            false,
            null,
            "No se encontró información de la cita. Verifica el enlace que estás usando."
        );
        btnSi.disabled = true;
        return;
    }


    mostrarDatosCitaParaCancelar();

});