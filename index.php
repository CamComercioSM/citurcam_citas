<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Citurcam Citas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/AdrianVillamayor/Wizard-JS@2.0.3/dist/main.min.css">
    <link rel="stylesheet" href="/style.css">
    <style>
        html,
        body {
            height: 100%;
        }

        body {
            min-height: 100vh;
            /* que siempre mida al menos el alto de la ventana */
            display: flex;
            flex-direction: column;
        }

        /* El contenido empuja el footer hacia abajo */
        #contenido-principal {
            flex: 1 0 auto;
        }

        .footer-ccsm {
            flex-shrink: 0;
            margin-top: auto;
            /* CLAVE: se pega al fondo cuando el contenido es corto */
            background-color: #003057;
            /* Azul institucional CCSM */
            color: white;
            padding-top: 20px;
            padding-bottom: 10px;
        }

        /* Ajustes responsivos */
        .footer-ccsm a {
            color: #cdd7e1;
            text-decoration: none;
        }

        .footer-ccsm a:hover {
            text-decoration: underline;
            color: #ffffff;
        }

        /* Ajuste para móviles */
        @media (max-width: 576px) {
            .footer-ccsm .col-md-3 {
                text-align: center;
                margin-bottom: 20px;
            }
        }
    </style>


    <script src="https://cdn.jsdelivr.net/gh/AdrianVillamayor/Wizard-JS@2.0.3/dist/index.js"></script>
    <script src="https://clientes.sicam32.net/javascript/?RVhERDM5OVA3aGV4RXFZMzMzazVlQjlxb0xIUSthQzNGKzRraXlTOFF6UT06OnpaNjJlakMzM3JWN1grcWEwM282Y2lwU0lERyt1U1pzN21rd1E1amNvd1E9"></script>

</head>

<body class="sb-nav-fixed page-wizard">
    <div id="contenido-principal">
        <main class="d-flex justify-content-center py-5">
            <div class="appointment-window">
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
                                <input class="form-check-input required" type="radio" id="aceptaTerminos" name="aceptaTerminos" />
                                <label class="form-check-label" for="aceptaTerminos">
                                    Acepta los
                                    <a href="https://www.ccsm.org.co/proteccion-de-datos-personales.html" target="_blank">
                                        Términos, Condiciones y Políticas de Privacidad de datos
                                    </a> personales de la Cámara de Comercio de Santa Marta para El Magdalena.
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
                                <input type="text" name="personaIDENTIFICACION" id="identificacion" class="form-control" pattern="^(?!0+$).*$" maxlength="15" required>
                            </div>
                            <div class="mt-3">
                                <label>Primer nombre *</label>
                                <input type="text" name="personaPRIMERNOMBRE" id="primerNombre" class="form-control" maxlength="200" required>
                            </div>
                            <div class="mt-3">
                                <label>Segundo nombre</label>
                                <input type="text" name="personaSEGUNDONOMBRE" id="segundoNombre" class="form-control" maxlength="200">
                            </div>
                            <div class="mt-3">
                                <label>Primer Apellido *</label>
                                <input type="text" name="personaPRIMERAPELLIDO" id="primerApellido" class="form-control" maxlength="200" required>
                            </div>
                            <div class="mt-3">
                                <label>Segundo apellido</label>
                                <input type="text" name="personaSEGUNDOAPELLIDO" id="segundoApellido" class="form-control" maxlength="200">
                            </div>
                            <div class="mt-3">
                                <label>Correo electrónico *</label>
                                <input type="email" name="correoDIRECCION" id="correo" class="form-control" maxlength="200" required>
                            </div>

                            <div class="mt-3">
                                <label>Numero celular *</label>
                                <input type="number" name="telefonoNUMERO" id="telefono" class="form-control" maxlength="15" required>
                            </div>

                        </div>
                    </aside>
                </form>
                <div id="confirmacionCita" class="text-center d-none">
                    <i class="bi bi-check-circle-fill text-success" style="font-size: 3rem;"></i>
                    <h3 class="mt-3">Tu cita fue creada correctamente</h3>
                    <p class="text-muted" id="confTextoIntro">Guarda esta información de tu cita:</p>

                    <div class="mt-4">
                        <div class="h5 mb-1">Codigo de cita</div>
                        <div class="display-5 fw-bold" id="confCodigoCita">—</div>
                    </div>

                    <div class="mt-4">
                        <p class="mb-1">
                            <strong>Fecha:</strong> <span id="confFecha">—</span><br>
                            <strong>Hora:</strong> <span id="confHora">—</span><br>
                            <strong>Módulo:</strong> <span id="confModulo">—</span><br>
                            <strong>Correo:</strong> <span id="confCorreo">—</span>
                        </p>
                    </div>

                    <button type="button" class="btn btn-primary mt-4" onclick="window.location.reload()">
                        Crear otra cita
                    </button>
                </div>
            </div>
        </main>
    </div> <!-- /contenido-principal -->


    <footer class="footer-ccsm">
        <div class="container py-4">

            <div class="row">
                <!-- LOGO -->
                <div class="col-md-3 text-center text-md-start mb-3">
                    <img src="https://www.ccsm.org.co/images/logo.png"
                        alt="Cámara de Comercio de Santa Marta"
                        class="img-fluid mb-2" style="max-width:200px;">
                    <p class="small text-white-50 mb-0">
                        Cámara de Comercio de Santa Marta para el Magdalena
                    </p>
                </div>

                <!-- ENLACES DE INTERÉS -->
                <div class="col-md-3 mb-3">
                    <h6 class="text-white fw-bold mb-2">Enlaces Institucionales</h6>
                    <ul class="list-unstyled text-white-50 small">
                        <li><a href="https://www.ccsm.org.co/es/" target="_blank">Sitio Oficial</a></li>
                        <li><a href="https://www.ccsm.org.co/es/quienes-somos.html" target="_blank">Quiénes Somos</a></li>
                        <li><a href="https://www.ccsm.org.co/es/atencion-al-cliente.html" target="_blank">Atención al Cliente</a></li>
                        <li><a href="https://www.ccsm.org.co/es/pqrs.html" target="_blank">PQRS</a></li>
                    </ul>
                </div>

                <!-- POLÍTICAS -->
                <div class="col-md-3 mb-3">
                    <h6 class="text-white fw-bold mb-2">Políticas y Documentos</h6>
                    <ul class="list-unstyled text-white-50 small">
                        <li><a href="https://www.ccsm.org.co/proteccion-de-datos-personales.html" target="_blank">
                                Protección de Datos Personales
                            </a></li>
                        <li><a href="https://www.ccsm.org.co/es/terminos-y-condiciones.html" target="_blank">
                                Términos y Condiciones
                            </a></li>
                        <li><a href="https://www.ccsm.org.co/es/politicas-de-uso.html" target="_blank">
                                Políticas de Uso
                            </a></li>
                    </ul>
                </div>

                <!-- CONTACTO -->
                <div class="col-md-3 mb-3">
                    <h6 class="text-white fw-bold mb-2">Contacto</h6>
                    <p class="small text-white-50 mb-1">
                        Calle 24 # 2-66, Santa Marta, Magdalena
                    </p>
                    <p class="small text-white-50 mb-1">Teléfono: (605) 420 9900</p>
                    <p class="small text-white-50">
                        Correo: <a href="mailto:contacto@ccsm.org.co">contacto@ccsm.org.co</a>
                    </p>
                </div>
            </div>

            <hr class="border-secondary">

            <div class="text-center">
                <p class="small text-white-50 mb-0">
                    © <span id="anioActual"></span> Cámara de Comercio de Santa Marta para el Magdalena.<br>
                    Todos los derechos reservados.
                </p>
            </div>

        </div>
    </footer>

    <script>
        document.getElementById("anioActual").textContent = new Date().getFullYear();
    </script>



    <div id="loadingOverlay" class="loading-overlay d-none" style="display: none;">
        <div class="loading-content">
            <img src="https://cdnsicam.net/img/ccsm/__Logo%20C%C3%A1mara%20para%20el%20Magdalena.png" alt="Cargando..." class="loading-icon">
            <p class="loading-text">Cargando...</p>
        </div>
    </div>

</body>

<script src="citas.js"></script>

</html>