//Funcion llamada desde abm-planificaciones.js
function getRequisitosAprobForm(url, data) {

    if (typeof PLANIFICACION === 'undefined' || typeof PLANIFICACION.id !== 'number') {
        return;
    }

    var url = SECCIONES.req_aprobacion;
    
    url = url.replace('--ID--', PLANIFICACION.id);
    
    console.log(url, PLANIFICACION);
    
    //var dialog = crearDialogEspera('Cargando <em>Requisitos Aprobación</em> ...');

    var success = function (response) {

        //console.log(response);
        $('#tab-content').hide().html(response).fadeIn();

        var btn = $('#btn-guardar-aprobacion');

        if (btn.length > 0) {

            btn.click(function (e) {
                e.preventDefault();

                //console.log("Clicccccck!!! ");
                var form_data = $('form').serialize();
                //console.log(form_data);
                updateReqAprobacionForm(url, form_data);

            });

        }

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


function onGuardarReqAprobacionClick(e) {

    e.preventDefault();

    if (typeof PLANIFICACION === 'undefined' || typeof PLANIFICACION.id !== 'number') {
        return;
    }

    var dialog = crearDialogEspera('Guardando Requisitos ...');


    var url = SECCIONES.req_aprobacion;

    url = url.replace('--ID--', PLANIFICACION.id);

    var form_data = $('form').serialize();

    var jqxhr = $.ajax({
        method: "POST",
        url: url,
        data: form_data,
        success: updateReqAprobacionHTML,
        dataType: 'html'
    });

    jqxhr.always(function () {
        dialog.modal('hide');
    });


}

function updateReqAprobacionForm(url, form_data) {
    //console.log(response);

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

function onChangePreve(e){
    e.preventDefault();
    alert('lala');
    $(".preveProm").show();  
    //$(".preveProm").hide();
}