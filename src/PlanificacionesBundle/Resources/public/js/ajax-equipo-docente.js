
function getFormEquipoDocente(url, data) {

    
    
    var tab_content = $('#tab-content');
    
    if(PLANIFICACION.id === null){
        var msg = "<p class='p-5 lead'>Para definir esta información debe completar los datos requeridos en la sección <em class='text-primary'>Informaci&oacute;n b&aacute;sica.</em></p>";
        tab_content.hide().html(msg).fadeIn();
        return;
    }else{
        tab_content.hide();
    }
    
    var dialog = crearDialogEspera('Cargando equipo docente ...');

    var success = function (response) {

        //console.log(response);
        $('#tab-content').hide().html(response).fadeIn();

        var btn = $('#btn-guardar-equipo-docente');

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