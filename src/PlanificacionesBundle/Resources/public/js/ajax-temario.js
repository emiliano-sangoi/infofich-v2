function getTemarioForm() {
    if (typeof PLANIFICACION === 'undefined' || typeof PLANIFICACION.id !== 'number') {
        return;
    }

    var url = SECCIONES.temario;
    url = url.replace('--ID--', PLANIFICACION.id);
    console.log(url, PLANIFICACION);

   // var dialog = crearDialogEspera('Cargando el temario  ...');

    var jqxhr = $.ajax({
        method: "GET",
        url: url,
        data: null,
        success: updateTemarioHTML,
        dataType: 'html'
    });
    
    
    jqxhr.always(function () {
       // dialog.modal('hide');
    });

}


function onGuardarTemarioClick(e) {
    e.preventDefault();
    

    if (typeof PLANIFICACION === 'undefined' || typeof PLANIFICACION.id !== 'number') {
        return;
    }
    
    var dialog = crearDialogEspera('Guardandando ...');

    var url = SECCIONES.temario;
    url = url.replace('--ID--', PLANIFICACION.id);
    
    //console.log("Clicccccck!!! ");
    var form_data = $('form').serialize();

    var jqxhr = $.ajax({
        method: "POST",
        url: url,
        data: form_data,
        success: updateTemarioHTML,
        dataType: 'html'
    });
    
    jqxhr.always(function () {
        dialog.modal('hide');
    });


}


function updateTemarioHTML(response){
    //console.log(response);        
        var target = $('#tab-content');
        target.hide().html(response)
        target.find('.temario-selector').collection();
        target.fadeIn();
}