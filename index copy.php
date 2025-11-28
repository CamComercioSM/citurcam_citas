<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Solicitud de Citas CCSM</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background: #f5f5f5;
        }

        .wizard-card {
            background: #ffffff;
            border-radius: 14px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            animation: fadeIn .3s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .step-title {
            font-size: 1.5rem;
            font-weight: 700;
        }

        .btn-main {
            background: #004085;
            color: white;
            font-weight: 600;
            border-radius: 8px;
            padding: 12px 22px;
        }

        .btn-main:hover {
            background: #002f5a;
        }

        .option-card {
            border: 2px solid #e0e0e0;
            border-radius: 12px;
            padding: 20px;
            cursor: pointer;
            text-align: center;
            transition: .2s;
        }

        .option-card.selected {
            border-color: #004085;
            background: #e8f1ff;
        }
    </style>
</head>

<body>

    <div class="container py-5">
        <div class="wizard-card mx-auto" style="max-width: 650px;">

            <!-- PASO 1 -->
            <div id="paso1">
                <div class="step-title mb-3"><i class="bi bi-calendar-check"></i> Tipo de cita</div>
                <p>Selecciona si deseas una cita virtual o presencial.</p>

                <div class="row g-3 mt-4">
                    <div class="col-6">
                        <div class="option-card" onclick="selectTipo('VIRTUAL')">
                            <i class="bi bi-laptop" style="font-size: 2.2rem;"></i>
                            <h5 class="mt-2">Virtual</h5>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="option-card" onclick="selectTipo('PRESENCIAL')">
                            <i class="bi bi-geo-alt" style="font-size: 2.2rem;"></i>
                            <h5 class="mt-2">Presencial</h5>
                        </div>
                    </div>
                </div>

                <div class="text-end mt-4">
                    <button disabled id="btnPaso1" class="btn-main" onclick="goPaso2()">Continuar</button>
                </div>
            </div>

            <!-- PASO 2 -->
            <div id="paso2" class="d-none">
                <div class="step-title mb-3"><i class="bi bi-calendar-week"></i> Seleccione la fecha</div>

                <p>Elige una fecha disponible según el tipo de cita.</p>

                <select id="selectFecha" class="form-select mt-3"></select>

                <div class="text-end mt-4">
                    <button class="btn btn-secondary" onclick="backTo(1)">Atrás</button>
                    <button class="btn-main" onclick="goPaso3()">Continuar</button>
                </div>
            </div>

            <!-- PASO 3 -->
            <div id="paso3" class="d-none">
                <div class="step-title mb-3"><i class="bi bi-people"></i> Seleccione un módulo</div>

                <div id="modulosContainer" class="mt-3"></div>

                <div class="text-end mt-4">
                    <button class="btn btn-secondary" onclick="backTo(2)">Atrás</button>
                    <button id="btnPaso3" disabled class="btn-main" onclick="goPaso4()">Continuar</button>
                </div>
            </div>

            <!-- PASO 4 -->
            <div id="paso4" class="d-none">
                <div class="step-title mb-3"><i class="bi bi-clock"></i> Seleccione la hora</div>

                <div id="horasContainer"></div>

                <div class="text-end mt-4">
                    <button class="btn btn-secondary" onclick="backTo(3)">Atrás</button>
                    <button id="btnPaso4" disabled class="btn-main" onclick="goPaso5()">Continuar</button>
                </div>
            </div>

            <!-- PASO 5 -->
            <div id="paso5" class="d-none">
                <div class="step-title mb-3"><i class="bi bi-person"></i> Datos de contacto</div>

                <div class="mt-3">
                    <label>Nombre completo</label>
                    <input class="form-control" id="nombre">
                </div>

                <div class="mt-3">
                    <label>Identificación</label>
                    <input class="form-control" id="identificacion">
                </div>

                <div class="mt-3">
                    <label>Correo electrónico</label>
                    <input class="form-control" id="correo">
                </div>

                <div class="mt-3">
                    <label>Teléfono</label>
                    <input class="form-control" id="telefono">
                </div>

                <div class="text-end mt-4">
                    <button class="btn btn-secondary" onclick="backTo(4)">Atrás</button>
                    <button class="btn-main" onclick="confirmar()">Confirmar Cita</button>
                </div>
            </div>

            <!-- Confirmación -->
            <div id="confirmacion" class="d-none text-center">
                <h2 class="text-success mb-3"><i class="bi bi-check-circle"></i> ¡Cita registrada!</h2>
                <p>Te llegará un correo con los detalles.</p>
            </div>

        </div>
    </div>


    <script>
        let tipoCita = null;
        let fechaSeleccionada = null;
        let moduloSeleccionado = null;
        let horaSeleccionada = null;

        document.getElementById("selectFecha").addEventListener("change", goPaso3);


        /* ====================
           FAKE API SIMULADA
           ==================== */
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

        /* ====================
           PASO 1
           ==================== */
        function selectTipo(tipo) {
            tipoCita = tipo;

            document.querySelectorAll(".option-card").forEach(c => c.classList.remove("selected"));
            event.currentTarget.classList.add("selected");

            // Avanzar automáticamente al siguiente paso
            goPaso2();
        }



        function goPaso2() {
            showStep(2);

            fakeApiFechas(tipoCita).then(resp => {
                let sel = document.getElementById("selectFecha");
                sel.innerHTML = "";
                resp.fechas.forEach(f => {
                    sel.innerHTML += `<option value="${f}">${f}</option>`;
                });
            });
        }

        /* ====================
           PASO 2
           ==================== */
        function goPaso3() {
            fechaSeleccionada = document.getElementById("selectFecha").value;
            showStep(3);

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

            // Avanzar automáticamente con el módulo seleccionado
            goPaso4();
        }


        /* ====================
           PASO 3
           ==================== */
        function goPaso4() {
            showStep(4);

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

            document.querySelectorAll("#horasContainer .option-card").forEach(c => c.classList.remove("selected"));
            element.classList.add("selected");

            // Avanzar automáticamente
            goPaso5();
        }


        /* ====================
           PASO 4
           ==================== */
        function goPaso5() {
            showStep(5);
        }

        /* ====================
           CONFIRMAR
           ==================== */
        function confirmar() {
            showStep("confirmacion");
        }

        /* ====================
           CONTROL DE PANTALLAS
           ==================== */
        function showStep(stepName) {

            const steps = ["paso1", "paso2", "paso3", "paso4", "paso5", "confirmacion"];

            steps.forEach(id => {
                const el = document.getElementById(id);
                if (el) el.classList.add("d-none");
            });

            // Si el paso es número → convertirlo a texto tipo paso2
            let targetID = stepName;

            if (typeof stepName === "number") {
                targetID = "paso" + stepName;
            }

            const target = document.getElementById(targetID);

            if (target) {
                target.classList.remove("d-none");
            } else {
                console.error("El paso solicitado no existe en el DOM:", targetID);
            }
        }

        function backTo(n) {
            showStep(n);
        }
    </script>

</body>

</html>