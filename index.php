<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Citurcam Citas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/AdrianVillamayor/Wizard-JS@2.0.3/dist/main.min.css">
    <link rel="stylesheet" href="style.css">
</head>

<body class="sb-nav-fixed">
    <main class="d-flex justify-content-center py-5">
        <main class="appointment-window">
            <div class="text-center mb-5">
                <img src="https://www.ccsm.org.co/images/logo.png" width="260" alt="Logo CCSM" class="img rounded img-fluid mx-auto d-block">
                <div class="h1 fw-light fw-bold py-3 mb-1">Solicita tu cita</div>
                <p class="text-muted mb-0">Sigue los pasos para generar tu cita.</p>
            </div>
            <form class="wizard" id="formWizard">
                <aside class="wizard-content container">
                    <div class="wizard-step" data-wz-title="Tipo de cita">
                        <input type="hidden" id="tipoCitaInput" name="citaTIPO" class="required">
                        <div class="form-group">
                            <div class="row g-3 mt-4">
                                <div class="col-6">
                                    <div class="option-card" onclick="selectTipo('VIRTUAL', event)">
                                        <i class="bi bi-laptop" style="font-size: 2.2rem;"></i>
                                        <h5 class="mt-2">Virtual</h5>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="option-card" onclick="selectTipo('PRESENCIAL',event)">
                                        <i class="bi bi-geo-alt" style="font-size: 2.2rem;"></i>
                                        <h5 class="mt-2">Presencial</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="wizard-step" data-wz-title="Fecha de la cita">
                        <div class="step-title mb-3"><i class="bi bi-calendar-week"></i> Seleccione la fecha</div>
                        <input type="hidden" id="flagFechaCita" name="flagFechaCita" value="0">
                        <p>Elige una fecha disponible según el tipo de cita.</p>

                        <div id="selectFecha" class="mt-3"></div>
                    </div>
                    <div class="wizard-step" data-wz-title="Módulo">
                        <div class="step-title mb-3"><i class="bi bi-people"></i> Seleccione un módulo</div>
                        <input type="hidden" id="flagModulo" name="flagModulo" value="0">
                        <div id="modulosContainer" class="mt-3"></div>

                    </div>
                    <div class="wizard-step" data-wz-title="Hora de la cita">
                        <div class="step-title mb-3"><i class="bi bi-clock"></i> Seleccione la hora</div>
                        <input type="hidden" id="flagHoraCita" name="flagHoraCita" value="" require>
                        <div id="horasContainer"></div>
                    </div>
                    <div class="wizard-step" data-wz-title="Datos personales">
                        <div class="step-title mb-3"><i class="bi bi-person"></i> Datos de contacto</div>
                        <div class="mt-4 form-check">
                            <input class="form-check-input required"
                                type="radio"
                                id="aceptaTerminos"
                                name="aceptaTerminos">
                            <label class="form-check-label" for="aceptaTerminos">
                                Acepto los términos y condiciones *
                            </label>
                        </div>
                        <div class="mt-3">
                            <label for="tipoIdentificacion">Tipo identificación *</label>
                            <select name="tipoIdentificacionID" id="tipoIdentificacion" class="form-control" required>
                                <option value="">Seleccione...</option>
                            </select>
                        </div>

                        <div class="mt-3">
                            <label>Identificación *</label>
                            <input type="text" name="personaIDENTIFICACION" id="identificacion" class="form-control" pattern="^(?!0+$).*$"  maxlength="15" required>
                        </div>
                        <div class="mt-3">
                            <label>Primer nombre *</label>
                            <input type="text" name="personaPRIMERNOMBRE" id="primerNombre" class="form-control"  maxlength="200" required>
                        </div>
                        <div class="mt-3">
                            <label>Segundo nombre</label>
                            <input type="text" name="personaSEGUNDONOMBRE" id="segundoNombre" class="form-control"  maxlength="200">
                        </div>
                        <div class="mt-3">
                            <label>Primer Apellido *</label>
                            <input type="text" name="personaPRIMERAPELLIDO" id="primerApellido" class="form-control"  maxlength="200" required>
                        </div>
                        <div class="mt-3">
                            <label>Segundo apellido</label>
                            <input type="text" name="personaSEGUNDOAPELLIDO" id="segundoApellido" class="form-control"  maxlength="200">
                        </div>
                        <div class="mt-3">
                            <label>Correo electrónico *</label>
                            <input type="email" name="personasCorreoPRINCIPAL" id="correo" class="form-control"  maxlength="200" required>
                        </div>

                        <div class="mt-3">
                            <label>Numero celular *</label>
                            <input type="number" name="telefonoNUMEROCELULAR" id="telefono" class="form-control"  maxlength="15" required>
                        </div>

                    </div>
                </aside>
            </form>

        </main>
        <script src="https://cdn.jsdelivr.net/gh/AdrianVillamayor/Wizard-JS@2.0.3/dist/index.js"></script>
        <script src="citas.js"></script>
</body>
<div id="loadingOverlay" class="loading-overlay d-none">
    <div class="loading-content">
        <img src="https://cdnsicam.net/img/ccsm/__Logo%20C%C3%A1mara%20para%20el%20Magdalena.png" alt="Cargando..." class="loading-icon">
        <p class="loading-text">Cargando...</p>
    </div>
</div>

</html>