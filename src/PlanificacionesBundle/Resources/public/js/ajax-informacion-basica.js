/**
 * Devuleve la url a la que va ir el ajax dependiendo de si esta
 * editando o creando la planificacion
 * 
 * @returns {String|resolveUrl.url}
 */
function resolveUrl() {
    var url = null;
    if (typeof PLANIFICACION === 'object' && typeof PLANIFICACION.id === 'number') {
        //se esta editando la planificacion
        url = SECCIONES.info_basica_edit;
        url = url.replace('--ID--', PLANIFICACION.id);

    } else {
        //no hay una planificacion creada
        url = SECCIONES.info_basica;
    }

    return url;
}

function cargarHTML(response) {
    var target = $('#tab-content');
    target.hide().html(response);

    // actualizar eventos
    target.find('.js-select2').select2({
        allowClear: true,
        containerCssClass: 'fix-select2-styles'
    });

    target.fadeIn();
}

/**
 * Carga el formulario de informacion basica.
 * 
 * @returns {undefined}
 */
function cargarFormInfoBasica() {

    var url = resolveUrl();

    var dialog = crearDialogEspera('Cargando <em>informaci&oacute;n b&aacute;sica</em> ...');

    var jqxhr = $.ajax({
        method: "GET",
        url: url,
        data: null,
        success: cargarHTML,
        dataType: 'html'
    });

    jqxhr.always(function () {
        dialog.modal('hide');
    });

}

/**
 * Evento que se ejecuta cuando se presiona el boton "Crear".
 * 
 * @param {type} e
 * @returns {undefined}
 */
function onGuardarInfoBasicaClick(e) {
    e.preventDefault();

    var dialog = crearDialogEspera('Guardandando ...');

    var onGuardarClickSuccess = function (planificacion_id) {        
        var goto = SECCIONES.editar_planif;
        goto = goto.replace('--ID--', planificacion_id);
        console.log(goto, SECCIONES.editar_planif, planificacion_id);
        window.location.href = goto;
    };


    var onGuardarClickError = function (response) {
        var target = $('#tab-content');
        target.hide().html(response.responseText);
        target.find('.js-select2').select2({
            allowClear: true,
            containerCssClass: 'fix-select2-styles'
        });

        target.fadeIn();
    };

    var form = $('form');

    var jqxhr = $.ajax({
        method: "POST",
        url: form.attr('action'),
        data: form.serialize(),
        success: onGuardarClickSuccess,
        error: onGuardarClickError,
        dataType: 'html'
    });

    jqxhr.always(function () {
        dialog.modal('hide');
    });


}

/**
 * Evento que se ejecuta cuando se presiona el boton "Guardar cambios".
 * 
 * @param {type} e
 * @returns {undefined}
 */
function onModificarInfoBasicaClick(e) {
    e.preventDefault();

    var dialog = crearDialogEspera('Guardando las modificaciones ...');

    var onGuardarClickError = function (response) {
        var target = $('#tab-content');
        target.hide().html(response.responseText);
        target.find('.js-select2').select2({
            allowClear: true,
            containerCssClass: 'fix-select2-styles'
        });

        target.fadeIn();

    };

    var form = $('form');
    var jqxhr = $.ajax({
        method: "POST",
        url: form.attr('action'),
        data: form.serialize(),
        success: cargarHTML,
        error: onGuardarClickError,
        dataType: 'html'
    });

    jqxhr.always(function () {
        dialog.modal('hide');
    });


}
