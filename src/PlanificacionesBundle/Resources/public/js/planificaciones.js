$(document).ready(function () {

    var msg = "<p class='lead'>Para cargar los datos de esta sección debe completar los datos requeridos en la sección <em class='text-primary'>Informaci&oacute;n b&aacute;sica.</em></p>";

    $('.js-select2-docentes').select2({
        placeholder: 'Seleccione un docente'
    });

}
);


function getDocente(legajo, item) {

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

        //console.log(response, item, dni, tel, email);
    };

    //pos es la posicion del docente en el listado
    var url = SECCIONES.get_docente;
    url = url.replace('--LEGAJO--', legajo);

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
    var target = item.find('.js-select2-docentes');
    target.select2({
        placeholder: 'Seleccione un docente'
    });

    // console.log(item);
//    target.change(function (event) {
//
//        var element = $(event.target);
//        var pos = element.val();
//
//        getDocente(pos, item);
//
//
//    });
}


/**
 * Actualiza el listado de asignaturas al cambiar la carrera elegida.
 *
 * @param {type} select
 * @returns {undefined}
 */
function actualizarAsignaturas(event) {
    
    var disabled = select_asignatura.attr('disabled') == 'disabled';

    // desactivar combo de asignaturas:
    select_asignatura.prop("disabled", true);
    
    var cargarAsignaturas = function (response) {
        
        if (response.length > 0) {
            console.log(response);
            select_asignatura.html('');
            select_asignatura.select2({
                'placeholder' : 'Todas las asignaturas de la carrera',
                allowClear: true
            });

            var opt = $(document.createElement('option'));
            opt.attr('value', '');
            //opt.attr('data-json', {});
            select_asignatura.append(opt);
            //opt.text(val.nombreMateria);

            response.forEach(function (val, index) {
                var opt = $(document.createElement('option'));

                opt.attr('value', val.codigoMateria);
                opt.attr('data-json', JSON.stringify(val));
                opt.text(val.nombreMateria);
                // console.log('Seleccionado: ' + aux, val.codigoMateria );
                if (typeof ASIGNATURA_ACTUAL !== 'undefined' && ASIGNATURA_ACTUAL == val.codigoMateria) {
                    opt.attr('selected', true);
                }

                select_asignatura.append(opt);
            });

            //activar el select o dejar desactivado:
            select_asignatura.prop("disabled", false);

        }
    };

    var carrera = $(select_carreras).val();
    console.log('carrera: ' + carrera);

    if (carrera != '1069' && carrera != '1071' && carrera != '1073' && carrera != '1077' && carrera != '1078' && carrera != '1075') {
        console.log('Ninguna carrera elegida');
        select_asignatura.html('');
        return;
    }

    //setear la carrera en la url:
    var url = SECCIONES.get_asignaturas;
    url = url.replace('--CARRERA--', carrera);

    $.ajax({
        dataType: "json",
        url: url,
        data: null,
        success: cargarAsignaturas,
        complete: function (data) {
            //esto se ejecuta cuando se terminan de cargar las asignaturas
            // y provoca que se cargue la informacion de la materia.                
            select_asignatura.trigger("change");

            if(ASIGNATURA_ACTUAL == -1){
                select_asignatura.val("");
            }
            
        }
    });

}
