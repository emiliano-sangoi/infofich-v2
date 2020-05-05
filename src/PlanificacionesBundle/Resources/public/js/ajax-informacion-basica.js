/**
 * Carga el formulario de informacion basica.
 * 
 * @returns {undefined}
 */
function cargarFormInfoBasica() {

    var url = SECCIONES.info_basica;

    var dialog = crearDialogEspera('Cargando <em>informaci&oacute;n b&aacute;sica</em> ...');

    var success = function (response, status) {
        //console.log(response, status);
        var target = $('#tab-content');
        target.hide().html(response);

        // actualizar eventos
        target.find('.js-select2').select2({
            allowClear: true,
            containerCssClass: 'fix-select2-styles'
        });

        target.fadeIn();
    };

    var jqxhr = $.ajax({
        method: "GET",
        url: url,
        data: null,
        success: success,
        dataType: 'html'
    });

    jqxhr.done(function () {
        //dialog.modal('hide');
    }).fail(function () {
        //alert("error");
    }).always(function () {
        dialog.modal('hide');
    });

}

/**
 * Evento que se ejecuta cuando se presiona el boton guardar.
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

    jqxhr.fail(function () {
        //alert("error");
    }).always(function () {
        dialog.modal('hide');
    });


}
