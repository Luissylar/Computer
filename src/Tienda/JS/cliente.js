document.addEventListener("DOMContentLoaded", function() {
    var mostrar_table = document.getElementById("mostrar");
    var formulario = document.getElementById("clienteForm");
    var tabla = document.getElementById("clienteTable");
    var visible = true; // Variable para rastrear el estado actual

    mostrar_table.addEventListener("click", function() {
        if (visible) {
            // Si la tabla está visible, ocultamos la tabla y mostramos el formulario
            tabla.style.display = "none";
            formulario.style.display = "block";
            
        } else {
            // Si el formulario está visible, lo ocultamos y mostramos la tabla
            formulario.style.display = "none";
            tabla.style.display = "flex";
        }
        // Cambiamos el estado
        visible = !visible;
    });
});
