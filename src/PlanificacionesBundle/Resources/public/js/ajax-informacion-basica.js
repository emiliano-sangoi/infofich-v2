
function getInfoBasicaForm(url, data) {

    var dialog = crearDialogEspera('Cargando <em>informaci&oacute;n b&aacute;sica</em> ...');

    var success = function (response) {

        //console.log(response);
        var target = $('#tab-content');
        target.hide().html(response);
        target.find('.js-select2').select2({
            allowClear: true,
            containerCssClass: 'fix-select2-styles'
        });

        //target.find('.select2-selection .select2-selection--single').addClass('height-fix');
        

        var btn = $('#btn-guardar-info-basica');

        if (btn.length > 0) {

            btn.click(function (e) {
                e.preventDefault();

                //console.log("Clicccccck!!! ");
                var form_data = $('form').serialize();
                //console.log(form_data);
                postInfoBasicaForm(url, form_data);

            });

            //disparar el evento en el select para que se recargue el listado de asignaturas
            var select_carrera = $('#planificacionesbundle_planificacion_carrera');
            select_carrera.trigger('change');


        }

        dialog.modal('hide');
        
        target.fadeIn();
    };

    $.ajax({
        method: "GET",
        url: url,
        data: data,
        success: success,
        dataType: 'html'
    });

}


function postInfoBasicaForm(url, form_data) {
    
    var dialog = crearDialogEspera('Guardandando ...');

    var success = function (response) {

        var target = $('#tab-content');
        target.hide().html(response);

        // console.log(PLANIFICACION);
        var planificacion_id = target.find("#planificacion_id");
        //console.log(planificacion_id, typeof planificacion_id, typeof planificacion_id === 'object')
        //actualizar el id de la planificacion
        if (typeof planificacion_id === 'object') {
            PLANIFICACION.id = planificacion_id.val();
            console.log(PLANIFICACION);
        }

        activarCierreAutomaticoNotificaciones();
        
        //activar el checkbox:
        activarTabCheck( $('#tab-info-basica i') );
        
        dialog.modal('hide');                
        
        target.fadeIn();
    };

    $.ajax({
        method: "POST",
        url: url,
        data: form_data,
        success: success,
        dataType: 'html'
    });


}