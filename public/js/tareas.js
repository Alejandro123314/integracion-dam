/**
 * Alejandro
 * 
 * Detectamos el click en el boton añadir para redireccionar al controlador CrearTareaController.php
 */
var cb = document.getElementById("crearButton");
cb.onclick = (e) => {
    var t = document.getElementById("titulo");
    if (t.value) {
        window.location.assign("/tareas/crear/" + t.value);
    }
}

/**
 * Alejandro
 * 
 * Detectamos el click en el boton filtrar para redireccionar al controlador ActualizarController.php
 */
var formulario = document.getElementById("formFiltro");
var fb = document.getElementById("filtroButton");
fb.onclick = (e) => {
    e.preventDefault();
    formulario.submit();
}
