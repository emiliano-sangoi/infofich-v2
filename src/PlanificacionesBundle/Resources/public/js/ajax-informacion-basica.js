
function getInfoBasicaForm(url, data) {

    var dialog = crearDialogEspera('Cargando <em>informaci&oacute;n b&aacute;sica</em> ...');

    var success = function (response) {

        //console.log(response);
        $('#tab-content').hide().html(response).fadeIn();

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
            select_carrera.select2();
            select_carrera.trigger('change');

        }

        dialog.modal('hide');
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


}