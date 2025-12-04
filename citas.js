let wz_class = ".wizard";
let tipoCita = null;
let citaFCHCITA = null;
let moduloAtencionID = null;
let turnoTipoServicioTITULO = null;
let horaSeleccionada = null;
let sedeID = '10';

const args = {
    "wz_class": ".wizard",
    "wz_nav_style": "dots",
    "wz_button_style": ".btn .btn-sm .mx-3",
    "wz_ori": "horizontal",
    "buttons": true,
    "navigation": "all",
    "finish": "Agendar",
    "bubble": true,
    "next": "Siguiente",
    "prev": "Atras"
};

const wizard = new Wizard(args);
wizard.init();

let $wz_doc = document.querySelector(wz_class);

//Eventos de cambio en tipo y numero de identificacion
let tipoIdent = document.getElementById("tipoIdentificacion");
let identificacion = document.getElementById("identificacion");
tipoIdent.addEventListener("change", function (e) {
    LlenarFormulario("tipo");
});
identificacion.addEventListener("change", function (e) {
    const valor = this.value.trim();

    if (/^0+$/.test(valor)) {
        return;
    }
    if (valor.length === 0) {
        return;
    }
    LlenarFormulario('identificacion');

});
identificacion.addEventListener("keydown", function (e) {
    if (e.key === "0" && this.selectionStart === 0) {
        e.preventDefault();
    }
});
async function LlenarFormulario(origen) {
    const tipoIdentificacionID = tipoIdent.value.trim();
    const personaIDENTIFICACION = identificacion.value.trim();
    let primerNombre = document.getElementById('primerNombre');
    let segundoNombre = document.getElementById('segundoNombre');
    let primerApellido = document.getElementById('primerApellido');
    let segundoApellido = document.getElementById('segundoApellido');
    let correoPersona = document.getElementById('correo');
    let numeroTelefono = document.getElementById('telefono');

    if (origen === "tipo" && !personaIDENTIFICACION) {
        return;
    }
    if (origen === "identificacion" && !tipoIdentificacionID) {
        return;
    }

    if (tipoIdentificacionID && personaIDENTIFICACION) {
        try {
            const datos = await conectarseEndPoint('consultarDatosPersona', { tipoIdentificacionID, personaIDENTIFICACION });
            if (datos) {
                primerNombre.value = datos.personaPRIMERNOMBRE || "";
                segundoNombre.value = datos.personaSEGUNDONOMBRE || "";
                primerApellido.value = datos.personaPRIMERAPELLIDO || "";
                segundoApellido.value = datos.personaSEGUNDOAPELLIDO || "";
                correoPersona.value = datos.personasCorreoPRINCIPAL || "";
                numeroTelefono.value = datos.telefonoNUMEROCELULAR || "";
            } else {
                console.log("No se encontraron datos para esa combinación.");
            }
            mostrarModalDeCarga(false);
        } catch (err) {
            console.error("Error consultando persona:", err);
        } finally {
            mostrarModalDeCarga(false);
        }
    }
}
async function cargarTiposIdentificacion() {
    const select = document.getElementById("tipoIdentificacion");
    if (!select) return;
    const respuesta = await conectarseEndPoint('datosFormularioCitas');
    const tiposIdentificacionData = respuesta.DATOS.TiposIdentificaciones;
    select.innerHTML = '<option value="">Seleccione...</option>';

    tiposIdentificacionData.forEach(t => {
        const opt = document.createElement("option");
        opt.value = t.tipoIdentificacionID;
        opt.textContent = t.tipoIdentificacionTITULO;
        select.appendChild(opt);
    });
    mostrarModalDeCarga(false);
}

$wz_doc.addEventListener("wz.btn.next", function (e) {

    const step = wizard.current_step;

    if (step === 0 && tipoCita) {
        crearTarjetasDeFechasDisponibles();
    }

    if (step === 1 && citaFCHCITA) {
        CrearTarjetasDeModulosDeAtencion();
    }
    if (step === 2 && moduloAtencionID) {
        CrearTarjetasDeHorasDisponibles();
    }
    if (step === 3 && horaSeleccionada) {
        cargarTiposIdentificacion();
    }

});

function avanzarPaso() {
    const nextBtn = document.querySelector('.wizard .wizard-btn.next');
    if (nextBtn) {
        nextBtn.click();
    }
}

function selectTipo(tipo, ev) {
    tipoCita = tipo;

    document
        .querySelectorAll(".option-card")
        .forEach(c => c.classList.remove("selected"));

    const card = ev.currentTarget;
    card.classList.add("selected");

    const inputTipo = document.getElementById("tipoCitaInput");
    inputTipo.value = tipo;
    avanzarPaso();
}

async function crearTarjetasDeFechasDisponibles() {
    if (!tipoCita) return;
    document.getElementById('flagFechaCita').value = '0';
    let sel = document.getElementById("selectFecha");
    sel.innerHTML = "";
    let hayFechas = false;
    const res = await conectarseEndPoint('buscarFechasCitasHabilitasPorSede', { sedeID });
    const fechas = res.FechasHabilitadas || [];
    if (fechas.length > 0) {
        hayFechas = true;
        fechas.forEach((f, index) => {
            const fechaTexto = f.fecha;
            sel.innerHTML += `
                <label class="option-card mt-2">
                    <input 
                        type="radio" 
                        name="citaFCHCITA" 
                        id="fechaCita${index}" 
                        value="${fechaTexto}"
                        data-require-if="flagFechaCita:0"
                        onchange="selectFechaCita('${fechaTexto}', this)"
                    >
                    <h5 class="mb-0">${fechaTexto}</h5>
                </label>
            `;
        });
    }
    if (!hayFechas) mostrarAlertaDePasoVacio(sel, 'No hay fechas disponibles para el tipo de cita');
    mostrarModalDeCarga(false);
}

function selectFechaCita(fecha, element) {
    citaFCHCITA = fecha;

    document
        .querySelectorAll("#selectFecha .option-card")
        .forEach(c => c.classList.remove("selected"));

    const card = element.closest('.option-card');
    if (card) {
        card.classList.add("selected");
    }
    const flag = document.getElementById('flagFechaCita');
    const algunoMarcado = !!document.querySelector('input[name="citaFCHCITA"]:checked');
    flag.value = algunoMarcado ? '1' : '0';
    avanzarPaso();
}

async function CrearTarjetasDeModulosDeAtencion() {
    if (!tipoCita) return;

    document.getElementById('flagModulo').value = '0';

    const res = await conectarseEndPoint('calendarioCitasDia', { sedeID, citaFCHCITA });
    let modulos = res.modulos || [];

    let cont = document.getElementById("modulosContainer");
    cont.innerHTML = "";
    let hayModulos = false;

    modulos = modulos.filter(mod => mod.moduloAtencionMODO == tipoCita);

    if (modulos.length > 0) {
        hayModulos = true;

        modulos.forEach((mod, index) => {
            cont.innerHTML += `
                <label class="option-card mt-2 modulo-${index}">
                    <input 
                        type="radio" 
                        name="moduloAtencionID" 
                        id="modulo${index}" 
                        value="${mod.moduloAtencionID}"
                        onchange="selectModulo('${mod.moduloAtencionID}', this)"
                        data-require-if="flagModulo:0"
                    >
                    <h5 class="mb-0">${mod.moduloAtencionTITULO}</h5>
                    <h6 class="mb-1">${mod.turnoTipoServicioTITULO}</h6>
                </label>
            `;
        });
    }
    if (!hayModulos) {
        mostrarAlertaDePasoVacio(
            cont,
            'No hay módulos disponibles para el tipo de cita seleccionado.'
        );
    }

    mostrarModalDeCarga(false);
}


function selectModulo(id, element) {
    moduloAtencionID = id;
    turnoTipoServicioTITULO = element.closest('.option-card').querySelector('h5').textContent || '';

    document
        .querySelectorAll("#modulosContainer .option-card")
        .forEach(c => c.classList.remove("selected"));

    const card = element.closest('.option-card');
    if (card) {
        card.classList.add("selected");
    }

    const flag = document.getElementById('flagModulo');
    const algunoMarcado = !!document.querySelector('input[name="moduloAtencionID"]:checked');
    flag.value = algunoMarcado ? '1' : '0';
    avanzarPaso();
}

async function CrearTarjetasDeHorasDisponibles() {
    if (!moduloAtencionID) return;
    document.getElementById('flagHoraCita').value = '0';
    let cont = document.getElementById("horasContainer");
    cont.innerHTML = "";
    let hayHoras = false;
    const res = await conectarseEndPoint('calendarioCitasDia', { sedeID, citaFCHCITA });
    const citasModulos = res.datos || [];
    if (citasModulos.length > 0) {
        citasModulos.forEach((bloque, index) => {
            const citaDisponible = bloque.citas.find(cita =>
                cita.moduloAtencionID == moduloAtencionID &&
                cita.personaID === null
            );
            if (!citaDisponible) {
                return;
            }
            hayHoras = true;
            const fechaHora = bloque.citaFCHCITA;
            const soloHora = fechaHora.split(" ")[1].substring(0, 5);

            const citaID = citaDisponible.citaID;
            cont.innerHTML += `
                <label class="option-card mt-2 hora-${index}">
                    <input 
                        type="radio" 
                        name="citaID" 
                        id="hora${index}" 
                        value="${citaID}"
                        onchange="selectHora('${soloHora}', this)"
                        data-require-if="flagHoraCita:0"
                    >
                    <h5 class="mb-0">${soloHora}</h5>
                </label>
            `;
        });
    }
    if (!hayHoras) {
        mostrarAlertaDePasoVacio(cont, 'No hay horas disponibles para el modulo seleccionado.');
    }
    mostrarModalDeCarga(false);
}

function selectHora(hora, element) {
    horaSeleccionada = hora;

    document
        .querySelectorAll("#horasContainer .option-card")
        .forEach(c => c.classList.remove("selected"));

    const card = element.closest('.option-card');
    if (card) {
        card.classList.add("selected");
    }

    const flag = document.getElementById('flagHoraCita');
    const algunoMarcado = !!document.querySelector('input[name="citaID"]:checked');
    flag.value = algunoMarcado ? '1' : '0';
    avanzarPaso();
}


$wz_doc.addEventListener("wz.form.submit", async function () {

    mostrarModalDeCarga(true);

    const formData = new FormData(document.querySelector(".wizard"));
    const params = {
        citaFCHCITA,
        horaSeleccionada,
        turnoTipoServicioTITULO
    };

    // Lista exacta de campos que SÍ quieres enviar
    const camposPermitidos = [
        "citaID",
        "citaTIPO",
        "tipoIdentificacionID",
        "personaIDENTIFICACION",
        "personaPRIMERNOMBRE",
        "personaSEGUNDONOMBRE",
        "personaPRIMERAPELLIDO",
        "personaSEGUNDOAPELLIDO",
        "correoDIRECCION",
        "telefonoNUMERO"
    ];

    formData.forEach((value, key) => {
        if (camposPermitidos.includes(key)) {
            params[key] = value;
        }
    });

    try {
        const res = await conectarseEndPoint('guardarCita', params);
        if (res.RESPUESTA !== "EXITO") {
            mostrarAlertaError(res.MENSAJE || 'Ocurrió un error al guardar la cita.');
            return;
        }
        mostrarAlertaExito(res.DATOS);
    } catch (error) {

    } finally {
        mostrarModalDeCarga(false);
    }
});



window.conectarseEndPoint = async function (operacion, params = {}) {
    const api = 'https://api.citurcam.com/' + operacion;

    if (typeof params !== 'object' || params === null) {
        params = params.toString();
    }
    mostrarModalDeCarga();
    const response = await fetch(api, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: JSON.stringify(params)
    });
    if (!response.ok) {
        throw new Error('Error en la petición: ' + response.status);
    }
    return await response.json();
}

function mostrarModalDeCarga(opcion = true) {
    if (opcion) {
        document.getElementById('loadingOverlay').classList.remove('d-none');
    } else {
        document.getElementById('loadingOverlay').classList.add('d-none');
    }
}

function mostrarAlertaDePasoVacio(contenedor, mensaje) {
    if (!contenedor) return;

    contenedor.innerHTML = `
        <div class="alerta-paso-vacio">
            ${mensaje}
        </div>

        <!-- Input "fantasma" requerido que bloquea el paso -->
        <input 
            type="text" 
            class="input-bloqueo-paso"
            required
            value=""
            tabindex="-1"
            aria-hidden="true"
        >
    `;
}

// function mostrarAlertaExito(datos) {
//     document.querySelector(".wizard").classList.add("d-none");
//     const conf = document.getElementById("confirmacionCita");
//     if (!conf) return;
//     conf.classList.remove("d-none");

//     // Llenar datos
//     document.getElementById("confCodigoCita").textContent = datos.citaID || "—";
//     document.getElementById("confFecha").textContent = datos.citaFCHCITA || "—";
//     document.getElementById("confHora").textContent = datos.horaSeleccionada || "—";
//     document.getElementById("confModulo").textContent = datos.turnoTipoServicioTITULO || "—";
//     document.getElementById("confCorreo").textContent = datos.correoDIRECCION || "—";
// }

function mostrarResultadoCita({ exito, datos = {}, mensajeError = "" }) {
    // Ocultar el wizard
    const wizard = document.querySelector(".wizard");
    if (wizard) wizard.classList.add("d-none");

    // Mostrar contenedor de resultado
    const conf = document.getElementById("confirmacionCita");
    if (!conf) return;
    conf.classList.remove("d-none");

    const icono = conf.querySelector("i");
    const titulo = conf.querySelector("h3");
    const textoIntro = document.getElementById("confTextoIntro");
    const detalleCita = document.getElementById("confDetalleCita");

    if (exito) {
        if (icono) {
            icono.classList.remove("text-danger", "bi-x-circle-fill");
            icono.classList.add("text-success", "bi-check-circle-fill");
        }

        if (titulo) titulo.textContent = "Tu cita fue creada correctamente";
        if (textoIntro) textoIntro.textContent = "Guarda esta información de tu cita:";
        if (detalleCita) detalleCita.classList.remove("d-none");

        // Llenar datos
        document.getElementById("confCodigoCita").textContent = datos.citaID || "—";
        document.getElementById("confFecha").textContent = datos.citaFCHCITA || "—";
        document.getElementById("confHora").textContent = datos.horaSeleccionada || "—";
        document.getElementById("confModulo").textContent = datos.turnoTipoServicioTITULO || "—";
        document.getElementById("confCorreo").textContent = datos.correoDIRECCION || "—";

    } else {
        // Icono / estilos de error
        if (icono) {
            icono.classList.remove("text-success", "bi-check-circle-fill");
            icono.classList.add("text-danger", "bi-x-circle-fill");
        }

        if (titulo) titulo.textContent = "No pudimos crear tu cita";
        if (textoIntro) {
            textoIntro.textContent =
                mensajeError || "Ocurrió un error al intentar guardar tu cita.";
        }

        // Ocultamos el detalle de cita
        if (detalleCita) detalleCita.classList.add("d-none");

        // Número de turno también lo dejamos vacío
        const numeroTurno = document.getElementById("confNumeroTurno");
        if (numeroTurno) numeroTurno.textContent = "—";
    }
}

function mostrarAlertaExito(datos) {
    mostrarResultadoCita({ exito: true, datos });
}

function mostrarAlertaError(mensaje) {
    mostrarResultadoCita({ exito: false, mensajeError: mensaje });
}