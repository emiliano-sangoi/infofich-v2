

/**
 * Crear un modal que muestra un spinner.
 * 
 * 
 * @param {type} title
 * @param {type} message
 * @returns {unresolved}
 */
function crearDialogEspera(message, title) {

    if (typeof title === 'undefined') {
        title = "<span class='text-primary'>Mensaje</span>";
    }

    var html = "<p class=''><i class='fa fa-spin fa-spinner'></i>&nbsp;&nbsp;";
    if (typeof message === 'undefined') {
        html += "Cargando contenido ...</p>";
    } else {
        html += message + '</p>';
    }

    var dialog = bootbox.dialog({
        title: title,
        message: html,
        //backdrop: true,
        size: 'large',
    });

    // Luego de cierto tiempo cerrar el dialogo.
    var TIMEOUT = 20000; //20 segundos
    dialog.init(function () {
        setTimeout(function () {
            dialog.find('.bootbox-body').html('No se pudo obtener el contenido de esta sección.');
        }, TIMEOUT);
    });

    return dialog;
}