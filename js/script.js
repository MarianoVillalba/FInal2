function mostrarAlerta(tipo, mensaje) {
    if (tipo === 'exito') {
        alert("Éxito: " + mensaje);
    } else if (tipo === 'error') {
        alert("Error: " + mensaje);
    }
}


window.onload = function() {
    const urlParams = new URLSearchParams(window.location.search);
    const resultado = urlParams.get('resultado');
    const mensaje = urlParams.get('mensaje');

    if (resultado && mensaje) {
        mostrarAlerta(resultado, mensaje);
    }
}
