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
