
function getObjetivosForm(url, data) {

    var dialog = crearDialogEspera('Cargando <em>Objetivos</em> ...');

    var success = function (response) {

        //console.log(response);
        $('#tab-content').hide().html(response).fadeIn();

        var btn = $('#btn-guardar-objetivos');

        if (btn.length > 0) {

            btn.click(function (e) {
                e.preventDefault();

                //console.log("Clicccccck!!! ");
                var form_data = $('form').serialize();
                //console.log(form_data);
                postObjetivosForm(url, form_data);

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


function postObjetivosForm(url, form_data) {

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