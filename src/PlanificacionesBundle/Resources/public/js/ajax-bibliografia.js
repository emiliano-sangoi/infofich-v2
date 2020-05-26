/*
function getBibliografiaForm(url, data) {

    var dialog = crearDialogEspera('Cargando bibliografia ...');

    var success = function (response) {

        //console.log(response);
        $('#tab-content').hide().html(response).fadeIn();

        var btn = $('#btn-guardar-bibliografia');

        if (btn.length > 0) {

            btn.click(function (e) {
                e.preventDefault();

                //console.log("Clicccccck!!! ");
                var form_data = $('form').serialize();
                //console.log(form_data);
                postBibliografiaForm(url, form_data);

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


function postBibliografiaForm(url, form_data) {

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


}*/

function getBibliografiaForm() {
    if (typeof PLANIFICACION === 'undefined' || typeof PLANIFICACION.id !== 'number') {
        return;
    }

    var url = SECCIONES.bibliografia;
    url = url.replace('--ID--', PLANIFICACION.id);
    console.log(url, PLANIFICACION);

   // var dialog = crearDialogEspera('Cargando el temario  ...');

    var jqxhr = $.ajax({
        method: "GET",
        url: url,
        data: null,
        success: updateBibliografiaHTML,
        dataType: 'html'
    });
    
    
    jqxhr.always(function () {
       // dialog.modal('hide');
    });

}


function onGuardarBibliografiaClick(e) {
    e.preventDefault();    

    if (typeof PLANIFICACION === 'undefined' || typeof PLANIFICACION.id !== 'number') {
        return;
    }
    
    var dialog = crearDialogEspera('Guardando ...');

    var url = SECCIONES.bibliografia;
    url = url.replace('--ID--', PLANIFICACION.id);
    
    var form_data = $('form').serialize();

    var jqxhr = $.ajax({
        method: "POST",
        url: url,
        data: form_data,
        success: updateBibliografiaHTML,
        dataType: 'html'
    });
    
    jqxhr.always(function () {
        dialog.modal('hide');
    });


}

function updateBibliografiaHTML(response){
    //console.log(response);        
        var target = $('#tab-content');
        target.hide().html(response)
        target.find('.bibliografia-selector').collection();
        target.fadeIn();
}