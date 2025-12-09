window.conectarseEndPoint = async function (operacion, params = {}) {
    const api = 'https://api.citurcam.com/' + operacion;

    if (typeof params !== 'object' || params === null) {
        params = params.toString();
    }
    mostrarModalDeCarga();
    try {
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

    } catch (error) {
        console.error("Error en conectarseEndPoint:", error);
        throw error;

    } finally {
        mostrarModalDeCarga(false);
    }
}
function mostrarModalDeCarga(opcion = true) {
    if (opcion) {
        document.getElementById('loadingOverlay').classList.remove('d-none');
    } else {
        document.getElementById('loadingOverlay').classList.add('d-none');
    }
}

window.agregarFooter = async function () {
    try {
        const resp = await fetch('https://cdnsicam.net/plantillas/apps/piecera-2026.html');
        const html = await resp.text();

        const contenedor = document.createElement("div");
        contenedor.innerHTML = html;

        while (contenedor.firstChild) {
            document.body.appendChild(contenedor.firstChild);
        }

    } catch (error) {
        console.error("Error cargando el footer:", error);
    }
};
window.validarPasoFinal = function () {
    const input = document.getElementById("aceptaTerminos");
    if (!input) return true; // si no existe, permitir continuar

    const contenedor = input.closest(".form-check") || input.parentElement;

    input.classList.remove("is-invalid");
    const previo = contenedor.querySelector(".mensaje-error");
    if (previo) previo.remove();

    const esValido = input.checked;

    if (!esValido) {
        input.classList.add("is-invalid");

        Swal.fire({
            icon: "warning",
            title: "Términos y condiciones",
            text: "Debe aceptar los términos y condiciones para continuar.",
            confirmButtonText: "Entendido",
            confirmButtonColor: "#3085d6",
            width: "420px",
            timer: 3500,
            timerProgressBar: true
        });

        return false;
    }

    return true;
};