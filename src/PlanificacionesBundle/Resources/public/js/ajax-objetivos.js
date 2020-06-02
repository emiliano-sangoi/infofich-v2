//Funcion llamada desde abm-planificaciones.js
function getObjetivosForm(url, data) {


    if (typeof PLANIFICACION === 'undefined' || typeof PLANIFICACION.id !== 'number') {
        return;
    }

    var url = SECCIONES.objetivos;

    url = url.replace('--ID--', PLANIFICACION.id);

    console.log(url, PLANIFICACION);

    //var dialog = crearDialogEspera('Cargando <em>Objetivos</em> ...');

    var success = function (response) {

        //console.log(response);
        $('#tab-content').hide().html(response).fadeIn();

        //dialog.modal('hide');
    };

    $.ajax({
        method: "GET",
        url: url,
        data: data,
        success: success,
        dataType: 'html'
    });

}


/*function postObjetivosForm(url, form_data) {

    var success = function (response) {
        //console.log(response);
        $('#tab-content').hide().html(response).fadeIn();
    };

    $.ajax({
        method: "POST",
        url: url,
        data: form_data,
        success: success,
        dataType: 'html'
    });

}*/

/**
 * Comment
 */
function onGuardarObjetivosClick(e) {
    e.preventDefault();

    if (typeof PLANIFICACION === 'undefined' || typeof PLANIFICACION.id !== 'number') {
        return;
    }

    var dialog = crearDialogEspera('Guardando objetivos ...');

    var url = SECCIONES.objetivos;
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