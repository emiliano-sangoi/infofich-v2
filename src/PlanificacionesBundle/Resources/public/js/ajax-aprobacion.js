//Funcion llamada desde abm-planificaciones.js
function getRequisitosAprobForm() {

    if (typeof PLANIFICACION === 'undefined' || typeof PLANIFICACION.id !== 'number') {
        return;
    }

    var url = SECCIONES.req_aprobacion;
    url = url.replace('--ID--', PLANIFICACION.id);
    console.log(url, PLANIFICACION);

     var jqxhr = $.ajax({
        method: "GET",
        url: url,
        data: null,
        success: updateReqAprobacionHTML,
        dataType: 'html'
    });
    
    
    jqxhr.always(function () {
       // dialog.modal('hide');
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

function updateReqAprobacionHTML(response) {
    //console.log(response);
    //alert('wasap');
    var target = $('#tab-content');
    target.hide().html(response);

    // actualizar eventos
    target.find('.js-select2').select2({
        allowClear: true,
        containerCssClass: 'fix-select2-styles'
    });

    target.fadeIn();
}