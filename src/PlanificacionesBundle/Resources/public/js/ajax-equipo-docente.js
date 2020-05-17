
function getFormEquipoDocente() {
    if (typeof PLANIFICACION === 'undefined' || typeof PLANIFICACION.id !== 'number') {
        return;
    }
    
    var dialog = crearDialogEspera('Cargando equipo docente ...');

    var url = SECCIONES.equipo_docente;
    url = url.replace('--ID--', PLANIFICACION.id);                 

    var jqxhr = $.ajax({
        method: "GET",
        url: url,
        data: null,
        success: updateEquipoDocenteHTML,
        dataType: 'html'
    });
    
    jqxhr.always(function () {
        dialog.modal('hide');
    });

}


function onGuardarCambiosDocentesClick(e) {
    e.preventDefault();
    
    if (typeof PLANIFICACION === 'undefined' || typeof PLANIFICACION.id !== 'number') {
        return;
    }

    var url = SECCIONES.equipo_docente;
    url = url.replace('--ID--', PLANIFICACION.id);      

    
    var form_data = $('form').serialize();

    $.ajax({
        method: "POST",
        url: url,
        data: form_data,
        success: updateEquipoDocenteHTML,
        dataType: 'html'
    });


}

function updateEquipoDocenteHTML(response){
    //console.log(response);        
        var target = $('#tab-content');
        target.hide().html(response);
        target.find('.docentes-colaboradores-selector').collection();
        target.find('.docentes-adscriptos-selector').collection();
        target.fadeIn();
}