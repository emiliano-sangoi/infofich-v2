//Funcion llamada desde abm-planificaciones.js
function getDistribucionForm(url, data) {

    if (typeof PLANIFICACION === 'undefined' || typeof PLANIFICACION.id !== 'number') {
        return;
    }

    var url = SECCIONES.distribucion;

    url = url.replace('--ID--', PLANIFICACION.id);

    var success = function (response) {

        $('#tab-content').hide().html(response).fadeIn();
    };

    $.ajax({
        method: "GET",
        url: url,
        data: data,
        success: success,
        dataType: 'html'
    });

}


function onGuardarDistribucionClick(e) {

    e.preventDefault();

    if (typeof PLANIFICACION === 'undefined' || typeof PLANIFICACION.id !== 'number') {
        return;
    }

    var dialog = crearDialogEspera('Guardando Distribucion ...');


    var url = SECCIONES.distribucion;

    url = url.replace('--ID--', PLANIFICACION.id);

    var form_data = $('form').serialize();

    var onGuardarClickSuccess = function (response) {
        $('#tab-content').hide().html(response).fadeIn();
        dialog.modal('hide');
    };

    var jqxhr = $.ajax({
        method: "POST",
        url: url,
        data: form_data,
        success: onGuardarClickSuccess,
        dataType: 'html'
    });

    jqxhr.always(function () {
        dialog.modal('hide');
    });


}