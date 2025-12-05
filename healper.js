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