<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Cancelar cita</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap 5 -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Icons -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css"
        rel="stylesheet">
    <link rel="stylesheet" href="/style.css">
</head>

<body class="page-cancelaciones">
    <div class="page-wrapper">
        <div class="card shadow-sm border-0 confirm-card">
            <div class="card-body p-4 p-md-5">
                <!-- BLOQUE DE PREGUNTA -->
                <div id="bloquePregunta" class="text-center">
                    <div class="mb-3">
                        <i class="bi bi-exclamation-circle-fill text-warning" style="font-size: 3rem;"></i>
                    </div>
                    <h2 class="mb-2">¿Estás seguro que quieres cancelar tu cita?</h2>
                    <p class="text-muted mb-3" id="preguntaTexto">
                        Esta acción no se puede deshacer. Si continúas, tu cita será cancelada.
                    </p>

                    <!-- AQUÍ mostramos la información básica de la cita (antes de cancelar) -->
                    <div id="infoCitaPregunta" class="mt-3 text-start mx-auto" style="max-width: 420px;">
                        <h5 class="mb-2">Información de tu cita</h5>
                        <p class="mb-1">
                            <strong>Código de cita:</strong>
                            <span class="ms-1" id="codigoCita">—</span>
                        </p>
                        <p class="mb-1">
                            <strong>Fecha:</strong>
                            <span class="ms-1" id="fechaCita">—</span>
                        </p>
                        <p class="mb-1">
                            <strong>Hora:</strong>
                            <span class="ms-1" id="horaCita">—</span>
                        </p>
                        <p class="mb-1">
                            <strong>Módulo:</strong>
                            <span class="ms-1" id="moduloCita">—</span>
                        </p>
                        <p class="mb-1">
                            <strong>Correo asociado:</strong>
                            <span class="ms-1" id="correoCita">—</span>
                        </p>
                    </div>

                    <!-- Botones (quedan más abajo gracias al bloque de info) -->
                    <div class="mt-4 d-flex flex-column flex-sm-row gap-2 justify-content-center">
                        <button id="btnConfirmarCancelacion" class="btn btn-danger">
                            Sí, estoy seguro
                        </button>
                        <button id="btnCancelarAccion" class="btn btn-outline-secondary">
                            No, volver
                        </button>
                    </div>
                </div>

                <!-- BLOQUE DE RESULTADO (ÉXITO / ERROR) -->
                <div id="bloqueResultado" class="text-center d-none">
                    <div class="mb-3">
                        <i id="iconResultado" class="bi bi-check-circle-fill text-success" style="font-size: 3rem;"></i>
                    </div>

                    <h2 id="tituloResultado" class="mb-2">Tu cita ha sido cancelada</h2>
                    <p id="textoResultadoIntro" class="text-muted mb-4">
                        La cancelación de tu cita se registró correctamente.
                    </p>

                    <hr>
                    <div class="mt-4 d-flex flex-column flex-sm-row gap-2 justify-content-center">
                        <button type="button" class="btn btn-outline-secondary" onclick="window.location.href='/'">
                            Volver al inicio
                        </button>
                        <button type="button" class="btn btn-primary" onclick="window.location.href='/'">
                            Agendar una nueva cita
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <?php include 'footer.php'; ?>

    <div class="modal fade" id="modalConfirmar" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Confirmar cancelación</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    ¿Deseas confirmar la cancelación de esta cita?
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        No, regresar
                    </button>
                    <button id="btnConfirmarAccionFinal" type="button" class="btn btn-danger">
                        Sí, cancelar cita
                    </button>
                </div>

            </div>
        </div>
    </div>
    <div id="loadingOverlay" class="loading-overlay d-none">
        <div class="loading-content">
            <img src="https://cdnsicam.net/img/ccsm/__Logo%20C%C3%A1mara%20para%20el%20Magdalena.png" alt="Cargando..." class="loading-icon">
            <p class="loading-text">Cargando...</p>
        </div>
    </div>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/healper.js"></script>
    <script src="/cancelaciones.js"></script>



</body>

</html>