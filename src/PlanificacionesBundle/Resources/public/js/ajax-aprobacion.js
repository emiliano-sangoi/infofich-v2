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

/*
 * Funcion llamada desde el onchage de las opciones de PreveProm
 */
function onChangePreve(e) {
    //Si hizo click en Si debe aparecer la Div con la clase prevePromDiv
    //Caso contrario ocultar la Div PrevePromDiv

    var radioValue = $("input[name='planificacionesbundle_planificacion[preveProm]']:checked").val();
 
    if (radioValue == 'Si') {
        $(".prevePromDiv").show();
      } else {
        $(".prevePromDiv").hide();
      }

}

/*
 * Funcion llamada desde el onchage de las opciones de PreveProm
 */
function onChangePreveIntegrador(e) {
    //Si hizo click en Si debe aparecer la Div con la clase prevePromDiv
    //Caso contrario ocultar la Div PrevePromDiv
    

    var radioValue = $("input[name='planificacionesbundle_planificacion[preveCfi]']:checked").val();
 alert(radioValue);
    if (radioValue == 'Si') {
        $(".preveCfiDiv").show();
      } else {
        $(".preveCfiDiv").hide();
      }
    
}