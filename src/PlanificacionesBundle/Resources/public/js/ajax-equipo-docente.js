
function getFormEquipoDocente(url, data) {

    var dialog = crearDialogEspera('Cargando equipo docente ...');

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
                postFormEquipoDocente(url, form_data);

            });

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


function postFormEquipoDocente(url, form_data) {

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