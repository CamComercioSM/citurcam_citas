let wz_class = ".wizard";
let tipoCita = null;
let fechaSeleccionada = null;
let moduloSeleccionado = null;
let horaSeleccionada = null;
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
    if (step === 3 && !horaSeleccionada) {
        e.preventDefault();
        alert("Por favor seleccione una hora para la cita.");
        return;
    }
});

function fakeApiFechas(tipo) {
    return new Promise(resolve => {
        setTimeout(() => {
            resolve({
                fechas: [
                    "2025-12-01",
                    "2025-12-02",
                    "2025-12-03"
                ]
            });
        }, 500);
    });
}
function fakeApiModulos(tipo, fecha) {
    return new Promise(resolve => {
        setTimeout(() => {
            resolve({
                modulos: [{
                    id: 10,
                    titulo: "Asesoría Especializada"
                },
                {
                    id: 20,
                    titulo: "Trámites y Registros"
                },
                {
                    id: 30,
                    titulo: "Turismo RNT"
                }
                ]
            });
        }, 600);
    });
}
function fakeApiHoras(moduloID) {
    return new Promise(resolve => {
        setTimeout(() => {
            resolve({
                horas: [
                    "08:00",
                    "08:20",
                    "08:40",
                    "09:00",
                    "09:20"
                ]
            });
        }, 500);
    });
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
    goPaso2();
}

function goPaso2() {
    if (!tipoCita) return;

    fakeApiFechas(tipoCita).then(resp => {
        let sel = document.getElementById("selectFecha");
        sel.innerHTML = "";

        resp.fechas.forEach((f, index) => {
            sel.innerHTML += `
                <label class="option-card mt-2">
                    <input type="radio" name="fechaCita" id="fechaCita${index}" value="${f}"  required>
                    <h5 class="mb-0">${f}</h5>
                </label>
            `;
        });
    });
}

function selectFechaCita(fecha, element) {
    fechaSeleccionada = fecha;

    document
        .querySelectorAll("#selectFecha .option-card")
        .forEach(c => c.classList.remove("selected"));

    element.classList.add("selected");

}

function goPaso3() {
    fechaSeleccionada = document.getElementById("selectFecha").value;
    fakeApiModulos(tipoCita, fechaSeleccionada).then(resp => {
        let cont = document.getElementById("modulosContainer");
        cont.innerHTML = "";

        resp.modulos.forEach(mod => {
            cont.innerHTML += `
                <div class="option-card mt-2" onclick="selectModulo(${mod.id}, this)">
                    <h5 class="mb-0">${mod.titulo}</h5>
                </div>
            `;
        });
    });
}

function selectModulo(id, element) {
    moduloSeleccionado = id;

    document.querySelectorAll("#modulosContainer .option-card").forEach(c => c.classList.remove("selected"));
    element.classList.add("selected");

    const inputModuloServicioCita = document.getElementById("moduloServicioCita");
    inputModuloServicioCita.value = id;

}

function goPaso4() {
    if (!moduloSeleccionado) return;
    fakeApiHoras(moduloSeleccionado).then(resp => {
        let cont = document.getElementById("horasContainer");
        cont.innerHTML = "";
        resp.horas.forEach(h => {
            cont.innerHTML += `
                <div class="option-card mt-2" onclick="selectHora('${h}', this)">
                    <h5>${h}</h5>
                </div>
            `;
        });
    });
}

function selectHora(hora, element) {
    horaSeleccionada = hora;

    document.querySelectorAll("#horasContainer .option-card")
        .forEach(c => c.classList.remove("selected"));

    element.classList.add("selected");

    const inputHoraCita = document.getElementById("horaCita");
    inputHoraCita.value = hora;
}

$wz_doc.addEventListener("wz.form.submit", function (e) {

    const formData = new FormData(document.querySelector(".wizard"));
    // Aquí puedes enviar con fetch o lo que quieras
    // Por ahora mostramos todo lo capturado:
    for (const [key, value] of formData.entries()) {
        console.log(`${key}: ${value}`);
    }

    alert("¡Cita agendada!");

});