let wz_class = ".wizard";
let tipoCita = null;
let citaFCHCITA = null;
let moduloAtencionID = null;
let horaSeleccionada = null;
let sedeID = '10';

const args = {
    "wz_class": ".wizard",
    "wz_nav_style": "dots",
    "wz_button_style": ".btn .btn-sm .mx-3",
    "wz_ori": "horizontal", // vertical
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

let tipoIdent = document.getElementById("tipoIdentificacion");
let identificacion = document.getElementById("identificacion");
tipoIdent.addEventListener("change", function (e) {
    LlenarFormulario("tipo");
});
identificacion.addEventListener("change", function (e) {
    LlenarFormulario('identificacion');
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
                console.log(datos.personasCorreoPRINCIPAL);
                primerNombre.value = datos.personaPRIMERNOMBRE || "";
                segundoNombre.value = datos.personaSEGUNDONOMBRE || "";
                primerApellido.value = datos.personaPRIMERAPELLIDO || "";
                segundoApellido.value = datos.personaSEGUNDOAPELLIDO || "";
                correoPersona.value = datos.personasCorreoPRINCIPAL || "";
                numeroTelefono.value = datos.telefonoNUMEROCELULAR || "";
            } else {
                console.log("No se encontraron datos para esa combinación.");
            }
        } catch (err) {
            console.error("Error consultando persona:", err);
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
}

$wz_doc.addEventListener("wz.btn.next", function (e) {

    const step = wizard.current_step;

    if (step === 0) {
        goPaso2();
    }

    if (step === 1) {
        goPaso3();
    }
    if (step === 2) {
        goPaso4();
    }
    if (step === 3) {
        if (!horaSeleccionada) {
            e.preventDefault();
            alert("Por favor seleccione una hora para la cita.");
            return;
        }
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

async function goPaso2() {
    if (!tipoCita) return;
    const res = await conectarseEndPoint('buscarFechasCitasHabilitasPorSede', { sedeID });
    const fechas = res.FechasHabilitadas || [];
    if (fechas) {
        document.getElementById('flagFechaCita').value = '0';
        let sel = document.getElementById("selectFecha");
        sel.innerHTML = "";
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

async function goPaso3() {
    document.getElementById('flagModulo').value = '0';
    const res = await conectarseEndPoint('calendarioCitasDia', { sedeID, citaFCHCITA });
    const modulos = res.modulos || [];

    if (modulos) {
        let cont = document.getElementById("modulosContainer");
        cont.innerHTML = "";
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
                <h5 class="mb-0">${mod.turnoTipoServicioTITULO}</h5>
            </label>
        `;
        });
    }

}

function selectModulo(id, element) {
    moduloAtencionID = id;

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

async function goPaso4() {
    if (!moduloAtencionID) return;
    document.getElementById('flagHoraCita').value = '0';
    const res = await conectarseEndPoint('calendarioCitasDia', { sedeID, citaFCHCITA });
    const citasModulos = res.datos || [];
    if (citasModulos) {
        let cont = document.getElementById("horasContainer");
        cont.innerHTML = "";
        citasModulos.forEach((bloque, index) => {
            const disponible = bloque.citas.some(cita =>
                cita.moduloAtencionID == moduloAtencionID &&
                cita.personaID === null
            );

            if (!disponible) {
                return;
            }
            const fechaHora = bloque.citaFCHCITA;
            const soloHora = fechaHora.split(" ")[1].substring(0, 5);
            cont.innerHTML += `
                <label class="option-card mt-2 hora-${index}">
                    <input 
                        type="radio" 
                        name="horaCITA" 
                        id="hora${index}" 
                        value="${soloHora}"
                        onchange="selectHora('${soloHora}', this)"
                        data-require-if="flagHoraCita:0"
                    >
                    <h5 class="mb-0">${soloHora}</h5>
                </label>
            `;
        });
    }
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
    const algunoMarcado = !!document.querySelector('input[name="horaCITA"]:checked');
    flag.value = algunoMarcado ? '1' : '0';
    avanzarPaso();
}


$wz_doc.addEventListener("wz.form.submit", async function () {

    const formData = new FormData(document.querySelector(".wizard"));

    const params = {};
    formData.forEach((value, key) => {
        params[key] = value;
    });


    //const res  = await conectarseEndPoint('guardarCita', params);

    console.log("Datos a enviar:", params);
    alert("¡Cita agendada!");

});

window.conectarseEndPoint = async function (operacion, params = {}) {
    const api = 'https://api.citurcam.com/' + operacion;

    if (typeof params !== 'object' || params === null) {
        params = params.toString();
    }
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
