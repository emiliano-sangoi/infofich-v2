//Funcion llamada desde abm-planificaciones.js
function getRequisitosAprobForm(url, data) {

    if (typeof PLANIFICACION === 'undefined' || typeof PLANIFICACION.id !== 'number') {
        return;
    }

    var url = SECCIONES.req_aprobacion;
    
    url = url.replace('--ID--', PLANIFICACION.id);
    
    var success = function (response) {

        $('#tab-content').hide().html(response).fadeIn();
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
    alert (123456);


    if (typeof PLANIFICACION === 'undefined' || typeof PLANIFICACION.id !== 'number') {
        return;
    }

    var dialog = crearDialogEspera('Guardando Requisitos ...');


    var url = SECCIONES.req_aprobacion;

    url = url.replace('--ID--', PLANIFICACION.id);

    var form_data = $('form').serialize();

    var onGuardarClickSuccess = function (response) {
        $('#tab-content').hide().html(response).fadeIn();
        dialog.modal('hide');
    };

    var jqxhr = $.ajax({
        method: "POST",
        url: url,
        data: form_data,
        success: onGuardarClickSuccess,
        dataType: 'html'
    });

    jqxhr.always(function () {
        dialog.modal('hide');
    });


}
/*
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
*/

function onChangePreve(e){
    e.preventDefault();
    alert('lala land');
    $(".preveProm").show();  
    //$(".preveProm").hide();
}