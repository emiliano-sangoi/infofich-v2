//Funcion llamada desde abm-planificaciones.js
function getResultadosForm() {
    if (typeof PLANIFICACION === 'undefined' || typeof PLANIFICACION.id !== 'number') {
        return;
    }

    var url = SECCIONES.resultados;
    url = url.replace('--ID--', PLANIFICACION.id);
    console.log(url, PLANIFICACION);

    var jqxhr = $.ajax({
        method: "GET",
        url: url,
        data: null,
        success: updateResultadosHTML,
        dataType: 'html'
    });
    
    
    jqxhr.always(function () {
       // dialog.modal('hide');
    });

}

/**
 * Comment
 */
function onGuardarResultadosClick(e) {
    e.preventDefault();    

    if (typeof PLANIFICACION === 'undefined' || typeof PLANIFICACION.id !== 'number') {
        return;
    }
    
    var dialog = crearDialogEspera('Guardando ...');

    var url = SECCIONES.resultados;
    url = url.replace('--ID--', PLANIFICACION.id);
    
    var form_data = $('form').serialize();

    var jqxhr = $.ajax({
        method: "POST",
        url: url,
        data: form_data,
        success: updateResultadosHTML,
        dataType: 'html'
    });
    
    jqxhr.always(function () {
        dialog.modal('hide');
    });


}

function updateResultadosHTML(response){
    console.log(response);        
        var target = $('#tab-content');
        target.hide().html(response)
        target.find('.resultado-selector').collection();
        target.fadeIn();
}