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
<footer class="footer-ccsm">
    <div class="container py-4">

        <div class="row">
            <!-- LOGO -->
            <div class="col-md-3 text-center text-md-start mb-3">
                <img src="https://cdnsicam.net/img/ccsm/logo-letra-blanca.png"
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