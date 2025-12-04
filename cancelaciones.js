document.addEventListener("DOMContentLoaded", function () {
    const modalConfirmar = new bootstrap.Modal(document.getElementById('modalConfirmar'));
    const path = window.location.pathname;
    const citaHash = path.split("/").pop().trim();
    console.log("HASH CITA:", citaHash);

    const bloquePregunta = document.getElementById("bloquePregunta");
    const bloqueResultado = document.getElementById("bloqueResultado");

    const btnSi = document.getElementById("btnConfirmarCancelacion");
    const btnNo = document.getElementById("btnCancelarAccion");
    const btnConfirmarAccionFinal = document.getElementById("btnConfirmarAccionFinal");
    const preguntaTexto = document.getElementById("preguntaTexto");

    // Referencias a elementos del bloque de resultado
    const icono = document.getElementById("iconResultado");
    const titulo = document.getElementById("tituloResultado");
    const textoIntro = document.getElementById("textoResultadoIntro");
    const detalle = document.getElementById("infoCitaPregunta");

    // Variable para guardar la cita y reutilizarla
    let datosCita = null;

    // Si no hay hash → mensaje de error y deshabilitar botón
    if (!citaHash || citaHash.toLowerCase() === "cancelaciones.php") {
        preguntaTexto.textContent = "No se encontró información de la cita. Verifica el enlace que estás usando.";
        btnSi.disabled = true;
        return;
    }

    async function mostrarDatosCitaParaCancelar() {
        try {
            const res = {
                "RESPUESTA": "EXITO",
                "MENSAJE": "",
                "DATOS": {
                    "citaID": "35568",
                    "citaFCHCITA": "2025-12-03 10:30:00",
                    "horaSeleccionada": "10:30",
                    "turnoTipoServicioTITULO": "Atención Empresarial",
                    "tipoIdentificacionID": "1",
                    "personaIDENTIFICACION": "1004382725",
                    "personaPRIMERNOMBRE": "Miguel",
                    "personaSEGUNDONOMBRE": "Angel",
                    "personaPRIMERAPELLIDO": "Acevedo",
                    "personaSEGUNDOAPELLIDO": "Florez",
                    "correoDIRECCION": "acebedo2524@gmail.com",
                    "telefonoNUMEROCELULAR": "3009939248"
                }
            };

            if (res.RESPUESTA !== "EXITO" || !res.DATOS) {
                preguntaTexto.textContent = "No fue posible obtener la información de tu cita.";
                btnSi.disabled = true;
                return;
            }

            datosCita = res.DATOS;

            // Modo "información", aún NO cancelada
            if (icono) icono.className = "bi bi-info-circle-fill text-primary";
            if (titulo) titulo.textContent = "Información de tu cita";
            if (textoIntro) textoIntro.textContent = "Revisa los datos de tu cita antes de confirmar la cancelación.";
            if (detalle) detalle.classList.remove("d-none");

            // Llenamos los datos
            document.getElementById("codigoCita").textContent = datosCita.citaID || "—";
            document.getElementById("fechaCita").textContent = datosCita.citaFCHCITA || "—";
            document.getElementById("horaCita").textContent = datosCita.horaSeleccionada || "—";
            document.getElementById("moduloCita").textContent = datosCita.turnoTipoServicioTITULO || "—";
            document.getElementById("correoCita").textContent = datosCita.correoDIRECCION || "—";

        } catch (error) {
            console.error(error);
            preguntaTexto.textContent = "Ocurrió un error al cargar la información de la cita.";
            btnSi.disabled = true;
        }
    }

    btnConfirmarAccionFinal.addEventListener("click", async function () {
        modalConfirmar.hide();
        if (!citaHash || !datosCita) return
        try {
            const res = {
                RESPUESTA: "EXITO",
                MENSAJE: ""
            };

            if (!res || res.RESPUESTA !== "EXITO") {
                const msg = (res && (res.MENSAJE || res.mensaje)) || "No fue posible cancelar tu cita.";
                mostrarResultado(false, null, msg);
            } else {
                mostrarResultado(true, datosCita);
            }

        } catch (err) {
            console.error(err);
            mostrarResultado(false, null, "Ocurrió un error de conexión. Intenta nuevamente.");
        } finally {
            //mostrarModalDeCarga(false);
        }
    });
    btnSi.addEventListener("click", async function () {
        modalConfirmar.show();
    });

    btnNo.addEventListener("click", function () {
        window.location.href = "/";
    });

    mostrarDatosCitaParaCancelar();

    function mostrarResultado(exito, datosCita = {}, mensajeError = "") {
        // Ocultamos la pregunta, dejamos solo el resultado
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
});