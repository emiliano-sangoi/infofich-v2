
function getViajesAcademicosForm(url, data) {

    if (typeof PLANIFICACION === 'undefined' || typeof PLANIFICACION.id !== 'number') {
        return;
    }

    var url = SECCIONES.viajes_academicos;
    url = url.replace('--ID--', PLANIFICACION.id);
    console.log(url, PLANIFICACION);

    // var dialog = crearDialogEspera('Cargando el viajes_academicos  ...');

    var jqxhr = $.ajax({
        method: "GET",
        url: url,
        data: null,
        success: updateViajesAcademicosHTML,
        dataType: 'html'
    });


    jqxhr.always(function () {
        // dialog.modal('hide');
    });

}


function onGuardarViajesAcademicosClick(e) {
    e.preventDefault();
    

    if (typeof PLANIFICACION === 'undefined' || typeof PLANIFICACION.id !== 'number') {
        return;
    }
    
    var dialog = crearDialogEspera('Guardando ...');

    var url = SECCIONES.viajes_academicos;
    url = url.replace('--ID--', PLANIFICACION.id);
    
    //console.log("Clicccccck!!! ");
    var form_data = $('form').serialize();

    var jqxhr = $.ajax({
        method: "POST",
        url: url,
        data: form_data,
        success: updateViajesAcademicosHTML,
        dataType: 'html'
    });
    
    jqxhr.always(function () {
        dialog.modal('hide');
    });


}

function updateViajesAcademicosHTML(url, form_data) {


    //console.log(response);        
    var target = $('#tab-content');
    target.hide().html(response)
    target.find('.viajeAcademico-selector').collection();
    target.fadeIn();


}