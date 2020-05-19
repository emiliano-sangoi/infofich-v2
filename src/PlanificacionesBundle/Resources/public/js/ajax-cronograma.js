
function getCronogramaForm(url, data) {

    if (typeof PLANIFICACION === 'undefined' || typeof PLANIFICACION.id !== 'number') {
        return;
    }

    var url = SECCIONES.cronograma;
    url = url.replace('--ID--', PLANIFICACION.id);
    console.log(url, PLANIFICACION);

    // var dialog = crearDialogEspera('Cargando el cronograma  ...');

    var jqxhr = $.ajax({
        method: "GET",
        url: url,
        data: null,
        success: updateCronogramaHTML,
        dataType: 'html'
    });


    jqxhr.always(function () {
        // dialog.modal('hide');
    });


}

function onGuardarCronogramaClick(e) {
    e.preventDefault();    

    if (typeof PLANIFICACION === 'undefined' || typeof PLANIFICACION.id !== 'number') {
        return;
    }
    
    var dialog = crearDialogEspera('Guardando ...');

    var url = SECCIONES.cronograma;
    url = url.replace('--ID--', PLANIFICACION.id);
    
    var form_data = $('form').serialize();

    var jqxhr = $.ajax({
        method: "POST",
        url: url,
        data: form_data,
        success: updateCronogramaHTML,
        dataType: 'html'
    });
    
    jqxhr.always(function () {
        dialog.modal('hide');
    });


}


function updateCronogramaHTML(response){
    //console.log(response);        
        var target = $('#tab-content');
        target.hide().html(response)
        target.find('.cronograma-selector').collection();
        target.fadeIn();
}