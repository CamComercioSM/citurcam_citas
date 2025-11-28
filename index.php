<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agendamiento de Citas - Wizard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        :root {
            --primary-color: #0d6efd; /* Azul moderno */
            --bg-light: #f8f9fa;
            --text-muted: #6c757d;
        }

        body {
            background-color: var(--bg-light);
            font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
        }

        /* Estilos del Wizard */
        .wizard-container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            overflow: hidden;
            min-height: 600px;
        }

        /* Barra de Progreso */
        .progress-indicator {
            display: flex;
            justify-content: space-between;
            margin-bottom: 2rem;
            position: relative;
        }
        .progress-indicator::before {
            content: '';
            position: absolute;
            top: 15px;
            left: 0;
            width: 100%;
            height: 2px;
            background: #e9ecef;
            z-index: 0;
        }
        .step-circle {
            width: 32px;
            height: 32px;
            background: #e9ecef;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            color: var(--text-muted);
            position: relative;
            z-index: 1;
            transition: all 0.3s ease;
        }
        .step-circle.active {
            background: var(--primary-color);
            color: white;
            box-shadow: 0 0 0 5px rgba(13, 110, 253, 0.2);
        }
        .step-circle.completed {
            background: #198754;
            color: white;
        }

        /* Ocultar pasos no activos */
        .wizard-step {
            display: none;
            animation: fadeIn 0.5s;
        }
        .wizard-step.active {
            display: block;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Tarjetas de Selección (Minimalistas) */
        .selection-card {
            border: 2px solid #e9ecef;
            border-radius: 10px;
            padding: 1.5rem;
            cursor: pointer;
            transition: all 0.2s;
            text-align: center;
        }
        .selection-card:hover {
            border-color: var(--primary-color);
            background-color: #f8faff;
        }
        .selection-card.selected {
            border-color: var(--primary-color);
            background-color: #e7f1ff;
            color: var(--primary-color);
            font-weight: bold;
        }

        .time-slot {
            font-size: 0.9rem;
            padding: 0.5rem;
        }
    </style>
</head>
<body>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="wizard-container p-4 p-md-5">
                
                <div class="text-center mb-4">
                    <h3 class="fw-bold text-dark">Agenda tu Cita</h3>
                    <p class="text-muted">Completa los pasos para programar tu atención.</p>
                </div>

                <div class="progress-indicator px-5">
                    <div class="step-circle active" id="circle-1">1</div>
                    <div class="step-circle" id="circle-2">2</div>
                    <div class="step-circle" id="circle-3">3</div>
                    <div class="step-circle" id="circle-4">4</div>
                </div>

                <form id="frm-wizard" onsubmit="return false;">
                    
                    <div class="wizard-step active" id="step-1">
                        <h5 class="mb-4">1. Preferencias de la Cita</h5>
                        
                        <div class="mb-4">
                            <label class="form-label text-muted small fw-bold">TIPO DE ATENCIÓN</label>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="selection-card" onclick="selectType(this, 'VIRTUAL')">
                                        <i class="fas fa-video fa-2x mb-2"></i><br>Virtual
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="selection-card" onclick="selectType(this, 'PRESENCIAL')">
                                        <i class="fas fa-building fa-2x mb-2"></i><br>Presencial
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" id="citaTIPO" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label text-muted small fw-bold">SEDE</label>
                            <select class="form-select" id="sedeID" onchange="fetchDatesAPI()">
                                <option value="">Seleccione una sede...</option>
                                <option value="1">Sede Principal - Centro</option>
                                <option value="2">Sede Norte</option>
                            </select>
                        </div>

                        <div class="mb-4" id="date-container" style="display:none;">
                            <label class="form-label text-muted small fw-bold">FECHA DISPONIBLE</label>
                            <div class="d-flex flex-wrap gap-2" id="dates-wrapper">
                                </div>
                            <input type="hidden" id="citaFCHCITA">
                        </div>
                    </div>

                    <div class="wizard-step" id="step-2">
                        <h5 class="mb-4">2. Selecciona el Módulo de Atención</h5>
                        <p class="text-muted small">Estos son los módulos disponibles para la fecha seleccionada.</p>
                        
                        <div class="row g-3" id="modules-container">
                            <div class="col-12 text-center py-5"><div class="spinner-border text-primary"></div></div>
                        </div>
                        <input type="hidden" id="moduloAtencionID">
                    </div>

                    <div class="wizard-step" id="step-3">
                        <h5 class="mb-4">3. Selecciona la Hora</h5>
                        <div class="row g-2" id="slots-container">
                            </div>
                        <input type="hidden" id="citaID">
                        <input type="hidden" id="citaHoraTexto">
                    </div>

                    <div class="wizard-step" id="step-4">
                        <h5 class="mb-4">4. Tus Datos de Contacto</h5>
                        
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Tipo Identificación *</label>
                                <select class="form-select" id="tipoIdentificacionID" required>
                                    <option value="">Seleccione...</option>
                                    <option value="CC">Cédula de Ciudadanía</option>
                                    <option value="TI">Tarjeta de Identidad</option>
                                    <option value="CE">Cédula de Extranjería</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Número Identificación *</label>
                                <input type="text" class="form-control" id="personaIDENTIFICACION" required>
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label">Primer Nombre *</label>
                                <input type="text" class="form-control" id="personaPRIMERNOMBRE" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Primer Apellido *</label>
                                <input type="text" class="form-control" id="personaPRIMERAPELLIDO" required>
                            </div>

                            <div class="col-md-12">
                                <label class="form-label">Email *</label>
                                <input type="email" class="form-control" id="correoDIRECCION" required>
                                <div class="form-text">Enviaremos la confirmación a este correo.</div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Celular *</label>
                                <input type="number" class="form-control" id="telefonoNUMERO" required>
                            </div>
                        </div>

                        <div class="mt-4 p-3 bg-light rounded border">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="aceptoPoliticas">
                                <label class="form-check-label small" for="aceptoPoliticas">
                                    Acepto los <a href="#" class="text-decoration-none">términos y condiciones</a> y la política de privacidad.
                                </label>
                            </div>
                        </div>

                        <div class="alert alert-info mt-3" role="alert">
                            <i class="fas fa-info-circle"></i> Estás agendando una cita 
                            <strong id="summary-type"></strong> para el 
                            <strong id="summary-date"></strong> a las 
                            <strong id="summary-time"></strong>.
                        </div>
                    </div>

                    <div class="d-flex justify-content-between mt-5 pt-3 border-top">
                        <button type="button" class="btn btn-outline-secondary px-4" id="btn-prev" onclick="changeStep(-1)" style="display:none;">
                            <i class="fas fa-arrow-left me-2"></i> Atrás
                        </button>
                        <button type="button" class="btn btn-primary px-4 ms-auto" id="btn-next" onclick="changeStep(1)">
                            Siguiente <i class="fas fa-arrow-right ms-2"></i>
                        </button>
                        <button type="button" class="btn btn-success px-4 ms-auto" id="btn-finish" onclick="submitForm()" style="display:none;">
                            Confirmar Cita <i class="fas fa-check ms-2"></i>
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // --- MOCK API DATA (Simulación de Backend) ---
    const API_DB = {
        dates: [
            { date: "2023-11-20", label: "Nov 20, Lun" },
            { date: "2023-11-21", label: "Nov 21, Mar" },
            { date: "2023-11-22", label: "Nov 22, Mié" },
            { date: "2023-11-23", label: "Nov 23, Jue" }
        ],
        modules: [
            { id: 101, name: "Módulo 1 - Atención General", description: "Primer piso" },
            { id: 102, name: "Módulo 2 - Caja", description: "Primer piso" },
            { id: 103, name: "Módulo 3 - Asesoría Jurídica", description: "Segundo piso" }
        ],
        slots: [
            { id: 501, time: "08:00 AM" },
            { id: 502, time: "08:30 AM" },
            { id: 503, time: "09:00 AM" },
            { id: 504, time: "09:30 AM" },
            { id: 505, time: "10:00 AM" },
            { id: 506, time: "10:30 AM" },
            { id: 507, time: "11:00 AM" },
            { id: 508, time: "02:00 PM" }
        ]
    };

    // --- VARIABLES DE ESTADO ---
    let currentStep = 1;
    const totalSteps = 4;

    // --- LÓGICA DE UI ---
    
    // Selección de Tipo (Visual)
    function selectType(element, value) {
        document.querySelectorAll('#step-1 .selection-card').forEach(el => el.classList.remove('selected'));
        element.classList.add('selected');
        document.getElementById('citaTIPO').value = value;
        
        // Intentar cargar fechas si ya hay sede
        fetchDatesAPI();
    }

    // Selección de Fecha (Visual)
    function selectDate(element, value) {
        document.querySelectorAll('.date-btn').forEach(el => el.classList.remove('btn-primary', 'text-white'));
        document.querySelectorAll('.date-btn').forEach(el => el.classList.add('btn-outline-primary'));
        
        element.classList.remove('btn-outline-primary');
        element.classList.add('btn-primary', 'text-white');
        
        document.getElementById('citaFCHCITA').value = value;
    }

    // Selección de Módulo
    function selectModule(element, id) {
        document.querySelectorAll('#step-2 .selection-card').forEach(el => el.classList.remove('selected'));
        element.classList.add('selected');
        document.getElementById('moduloAtencionID').value = id;
    }

    // Selección de Hora
    function selectSlot(element, id, timeText) {
        document.querySelectorAll('.slot-btn').forEach(el => el.classList.remove('btn-primary', 'text-white'));
        document.querySelectorAll('.slot-btn').forEach(el => el.classList.add('btn-outline-secondary'));
        
        element.classList.remove('btn-outline-secondary');
        element.classList.add('btn-primary', 'text-white');
        
        document.getElementById('citaID').value = id;
        document.getElementById('citaHoraTexto').value = timeText;
        
        // Actualizar resumen
        document.getElementById('summary-type').innerText = document.getElementById('citaTIPO').value;
        document.getElementById('summary-date').innerText = document.getElementById('citaFCHCITA').value;
        document.getElementById('summary-time').innerText = timeText;
    }

    // --- SIMULACIÓN DE LLAMADAS API ---

    // 1. Consultar Fechas (Triggered en Paso 1)
    function fetchDatesAPI() {
        const tipo = document.getElementById('citaTIPO').value;
        const sede = document.getElementById('sedeID').value;

        if(tipo && sede) {
            // Simular loading
            const container = document.getElementById('date-container');
            const wrapper = document.getElementById('dates-wrapper');
            container.style.display = 'block';
            wrapper.innerHTML = '<div class="spinner-border spinner-border-sm text-primary"></div> Buscando disponibilidad...';

            setTimeout(() => {
                wrapper.innerHTML = '';
                API_DB.dates.forEach(d => {
                    const btn = document.createElement('button');
                    btn.className = 'btn btn-outline-primary date-btn px-4 py-2';
                    btn.innerHTML = `<strong>${d.label}</strong>`;
                    btn.onclick = () => selectDate(btn, d.date);
                    wrapper.appendChild(btn);
                });
            }, 800); // 800ms de delay simulado
        }
    }

    // 2. Consultar Módulos (Al entrar al Paso 2)
    function fetchModulesAPI() {
        const container = document.getElementById('modules-container');
        container.innerHTML = '<div class="col-12 text-center py-4"><div class="spinner-border text-primary"></div></div>';

        setTimeout(() => {
            container.innerHTML = '';
            API_DB.modules.forEach(mod => {
                const col = document.createElement('div');
                col.className = 'col-md-6 col-lg-4';
                col.innerHTML = `
                    <div class="selection-card h-100 d-flex flex-column justify-content-center" onclick="selectModule(this, '${mod.id}')">
                        <i class="fas fa-desktop fa-2x mb-3 text-muted"></i>
                        <h6 class="fw-bold">${mod.name}</h6>
                        <small class="text-muted">${mod.description}</small>
                    </div>
                `;
                container.appendChild(col);
            });
        }, 800);
    }

    // 3. Consultar Citas/Horas (Al entrar al Paso 3)
    function fetchSlotsAPI() {
        const container = document.getElementById('slots-container');
        container.innerHTML = '<div class="col-12 text-center py-4"><div class="spinner-border text-primary"></div></div>';

        setTimeout(() => {
            container.innerHTML = '';
            API_DB.slots.forEach(slot => {
                const col = document.createElement('div');
                col.className = 'col-6 col-md-3 col-lg-2';
                col.innerHTML = `
                    <button class="btn btn-outline-secondary w-100 slot-btn" onclick="selectSlot(this, '${slot.id}', '${slot.time}')">
                        ${slot.time}
                    </button>
                `;
                container.appendChild(col);
            });
        }, 600);
    }

    // --- CONTROL DEL WIZARD ---

    function validateStep(step) {
        if(step === 1) {
            if(!document.getElementById('citaTIPO').value) { Swal.fire('Error', 'Selecciona el tipo de cita', 'warning'); return false; }
            if(!document.getElementById('sedeID').value) { Swal.fire('Error', 'Selecciona una sede', 'warning'); return false; }
            if(!document.getElementById('citaFCHCITA').value) { Swal.fire('Error', 'Selecciona una fecha', 'warning'); return false; }
        }
        if(step === 2) {
            if(!document.getElementById('moduloAtencionID').value) { Swal.fire('Error', 'Selecciona un módulo', 'warning'); return false; }
        }
        if(step === 3) {
            if(!document.getElementById('citaID').value) { Swal.fire('Error', 'Selecciona una hora', 'warning'); return false; }
        }
        return true;
    }

    function changeStep(direction) {
        // Validar antes de avanzar
        if(direction === 1 && !validateStep(currentStep)) return;

        const nextStep = currentStep + direction;

        // Limites
        if(nextStep < 1 || nextStep > totalSteps) return;

        // Ocultar actual
        document.getElementById(`step-${currentStep}`).classList.remove('active');
        document.getElementById(`circle-${currentStep}`).classList.remove('active');
        if(direction === 1) document.getElementById(`circle-${currentStep}`).classList.add('completed');
        if(direction === -1) document.getElementById(`circle-${nextStep}`).classList.remove('completed');

        // Mostrar siguiente
        document.getElementById(`step-${nextStep}`).classList.add('active');
        document.getElementById(`circle-${nextStep}`).classList.add('active');

        currentStep = nextStep;

        // Control de botones
        document.getElementById('btn-prev').style.display = currentStep === 1 ? 'none' : 'block';
        
        if(currentStep === totalSteps) {
            document.getElementById('btn-next').style.display = 'none';
            document.getElementById('btn-finish').style.display = 'block';
        } else {
            document.getElementById('btn-next').style.display = 'block';
            document.getElementById('btn-finish').style.display = 'none';
        }

        // Triggers de API al cambiar de paso
        if(currentStep === 2) fetchModulesAPI();
        if(currentStep === 3) fetchSlotsAPI();
    }

    function submitForm() {
        // Validar Paso 4
        const requiredIds = ['tipoIdentificacionID', 'personaIDENTIFICACION', 'personaPRIMERNOMBRE', 'personaPRIMERAPELLIDO', 'correoDIRECCION', 'telefonoNUMERO'];
        for(let id of requiredIds) {
            if(!document.getElementById(id).value) {
                Swal.fire('Campos incompletos', 'Por favor diligencia todos los campos obligatorios (*)', 'error');
                return;
            }
        }

        if(!document.getElementById('aceptoPoliticas').checked) {
            Swal.fire('Atención', 'Debes aceptar los términos y condiciones', 'warning');
            return;
        }

        // Si todo está bien
        Swal.fire({
            title: '¡Cita Agendada!',
            text: 'Tu cita ha sido reservada con éxito. Hemos enviado un correo de confirmación.',
            icon: 'success',
            confirmButtonText: 'Finalizar'
        }).then(() => {
            location.reload(); // Reiniciar formulario
        });
        
        // Aquí iría tu lógica real de envío: enviarDatosFormulario(...)
        const datosFinales = {
            citaID: document.getElementById('citaID').value,
            identificacion: document.getElementById('personaIDENTIFICACION').value,
            // ... resto de campos
        };
        console.log("Enviando API:", datosFinales);
    }

</script>

</body>
</html>