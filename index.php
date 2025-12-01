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
    <main class="container-fluid pt-5">
        <main class="container">
            <form class="wizard" id="formWizard">
                <aside class="wizard-content container">
                    <div class="wizard-step" data-title="Adrii">
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
                    <div class="wizard-step">
                        <div class="step-title mb-3"><i class="bi bi-calendar-week"></i> Seleccione la fecha</div>
                        <input type="hidden" id="flagFechaCita" name="flagFechaCita" value="0">
                        <p>Elige una fecha disponible según el tipo de cita.</p>

                        <div id="selectFecha" class="mt-3"></div>
                    </div>
                    <div class="wizard-step">
                        <div class="step-title mb-3"><i class="bi bi-people"></i> Seleccione un módulo</div>
                        <input type="hidden" id="flagModulo" name="flagModulo" value="0">
                        <div id="modulosContainer" class="mt-3"></div>

                    </div>
                    <div class="wizard-step">
                        <div class="step-title mb-3"><i class="bi bi-clock"></i> Seleccione la hora</div>
                        <input type="hidden" id="flagHoraCita" name="flagHoraCita" value="0">
                        <div id="horasContainer"></div>
                    </div>
                    <div class="wizard-step" data-title="Adrii">
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
                            <input type="text" name="personaIDENTIFICACION" id="identificacion" class="form-control" required>
                        </div>
                        <div class="mt-3">
                            <label>Primer nombre *</label>
                            <input type="text" name="personaPRIMERNOMBRE" id="primerNombre" class="form-control" required>
                        </div>
                        <div class="mt-3">
                            <label>Segundo nombre</label>
                            <input type="text" name="personaSEGUNDONOMBRE" id="segundoNombre" class="form-control">
                        </div>
                        <div class="mt-3">
                            <label>Primer Apellido *</label>
                            <input type="text" name="personaPRIMERAPELLIDO" id="primerApellido" class="form-control" required>
                        </div>
                        <div class="mt-3">
                            <label>Segundo apellido</label>
                            <input type="text" name="personaSEGUNDOAPELLIDO" id="segundoApellido" class="form-control">
                        </div>
                        <div class="mt-3">
                            <label>Correo electrónico</label>
                            <input type="email" name="personasCorreoPRINCIPAL" id="correo" class="form-control" required>
                        </div>

                        <div class="mt-3">
                            <label>Teléfono</label>
                            <input type="number" name="telefonoNUMEROCELULAR" id="telefono" class="form-control" required>
                        </div>

                    </div>
                </aside>
            </form>

        </main>
        <script src="https://cdn.jsdelivr.net/gh/AdrianVillamayor/Wizard-JS@2.0.3/dist/index.js"></script>
        <script src="citas.js"></script>
</body>

</html>