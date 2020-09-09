$(document).ready(function () {

    var msg = "<p class='lead'>Para cargar los datos de esta sección debe completar los datos requeridos en la sección <em class='text-primary'>Informaci&oacute;n b&aacute;sica.</em></p>";


}
);
/**
 * Actualiza el listado de asignaturas al cambiar la carrera elegida.
 *
 * @param {type} select
 * @returns {undefined}
 */
function actualizarAsignaturas(select) {

    var carrera = $(select).val();
    //console.log('Carrera elegida: ' + carrera);
    //Actualizar input Plan de estudio:
    var planes = JSON.parse($(select).attr('data-planes-carrera'));
    if (typeof planes === 'object' && typeof planes[carrera] === 'string') {
        $('#planificacionesbundle_planificacion_plan').attr('value', planes[carrera]);
    }

    //Define el ecomportamiento del select de asignatura sin disparar el evento:
    var select_asignatura = $('#planificacionesbundle_planificacion_asignatura');
    select_asignatura.addClass('disabled');
    select_asignatura.change(function (e) {
        var option = $(this).children("option:selected");
        var asignatura = JSON.parse(option.attr('data-json'));
        $('#planificacionesbundle_planificacion_codigoSiu').val(asignatura.codigoMateria);
        console.log(asignatura);
    });
    //setear la carrera en la url:
    var url = SECCIONES.get_asignaturas;
    url = url.replace('--CARRERA--', carrera);
    //llamada ajax
    $.ajax({
        dataType: "json",
        url: url,
        data: null,
        success: function (response) {

            if (response.length > 0) {
                select_asignatura.html('');
                response.forEach(function (val, index) {
                    var opt = $(document.createElement('option'));
                    opt.attr('value', val.codigoMateria);
                    opt.attr('data-json', JSON.stringify(val));
                    opt.text(val.nombreMateria);
                    select_asignatura.append(opt);
                });
                //Esto produce que se complete los datos de la asignatura.
                select_asignatura.select2({
                    allowClear: true,
                    containerCssClass: 'fix-select2-styles'
                });
                select_asignatura.trigger('change');
                select_asignatura.removeClass('disabled');
            }
        }
    });
}

function getDocente(pos, item) {

    //Actualiza los campos dni, telefono y email
    var successCallback = function (response) {
        var dni = item.find('.nro-dni');
        if (dni.length > 0) {
            dni.val(response.numeroDocumento.length > 0 ? response.numeroDocumento : '-');
        }

        var tel = item.find('.telefono');
        if (tel.length > 0) {
            //TODO: pedir si se puede agregar el telefono en rectorado.
            tel.val('-');
        }

        var email = item.find('.email');
        if (email.length > 0) {
            email.val(response.email.length > 0 ? response.email : '-');
        }

        console.log(response, item, dni, tel, email);
    };

    //pos es la posicion del docente en el listado
    var url = SECCIONES.get_docente;
    url = url.replace('--POS--', pos);

    $.ajax({
        method: "GET",
        url: url,
        data: null,
        success: successCallback,
        dataType: 'json'
    });

}

/**
 * Callback que se ejecuta en equipo docente luego de agregar un docente
 * 
 * @param {type} collection
 * @param {type} item
 * @returns {undefined}
 */
function afterAddDocente(collection, item) {
    var target = item.find('.js-select2');
    target.select2({
        allowClear: true,
        containerCssClass: 'fix-select2-styles'
    });

    // console.log(item);
    target.change(function (event) {

        var element = $(event.target);
        var pos = element.val();

        getDocente(pos, item);


    });
}
;
