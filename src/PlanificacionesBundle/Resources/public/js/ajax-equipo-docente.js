
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

function updateEquipoDocenteHTML(response) {

    var afterAdd = function (collection, item) {
        var target = item.find('.js-select2');
        target.select2({
            allowClear: true,
            containerCssClass: 'fix-select2-styles'
        });

        // console.log(item);
        target.change(function (event) {

            var element = $(event.target);
            var pos = element.val();

            getDocente(pos, item);


        });
    };

    //console.log(response);        
    var target = $('#tab-content');
    target.hide().html(response);
    target.find('.docentes-colaboradores-selector').collection({
        after_add: afterAdd
    });
    target.find('.docentes-adscriptos-selector').collection({
        after_add: afterAdd
    });
     
    var select = target.find('.js-select2');

    // Instanciar select:
    select.select2({
        allowClear: true,
        containerCssClass: 'fix-select2-styles'
    });

    select.change(function (event) {
        var element = $(event.target);
        var pos = element.val();

        getDocente(pos, $('#docentes_docenteResponsable'));

    });
    //select.trigger('change');    

    // Set evento en select:    
    //select.addClass('disabled');

    target.fadeIn();
}


function onDocenteAddClick(event) {

//    console.log("lala");
//
//    var onChangeSelect = function (event) {
//        var element = $(event.target);
//        console.log(element, element.val());
//    };

//    $('.js-select2').each(function (i, obj) {
//        console.log($(obj).data('select2-id'));
//        if (!$(obj).data('select2-id'))
//        {
//            $(obj).select2({
//                allowClear: true,
//                containerCssClass: 'fix-select2-styles'
//            });
//
//            $(obj).change(onChangeSelect);
//        }
//    });

}


function getDocente(pos, item) {

    //Actualiza los campos dni, telefono y email
    var successCallback = function (response) {
        var dni = item.find('.nro-dni');
        if (dni.length > 0) {
            dni.val(response.numeroDocumento.length > 0 ? response.numeroDocumento : '-');
        }

        var tel = item.find('.telefono');
        if (tel.length > 0) {
            //TODO: pedir si se puede agregar el telefono en rectorado.
            tel.val('-');
        }

        var email = item.find('.email');
        if (email.length > 0) {
            email.val(response.email.length > 0 ? response.email : '-');
        }

        console.log(response, item, dni, tel, email);
    };

    //pos es la posicion del docente en el listado
    var url = SECCIONES.get_docente;
    url = url.replace('--POS--', pos);

    $.ajax({
        method: "GET",
        url: url,
        data: null,
        success: successCallback,
        dataType: 'json'
    });

}




//$('.js-select2').on('load', function (event) {
//    console.log("lala");
//    $(this).select2({
//        allowClear: true,
//        containerCssClass: 'fix-select2-styles'
//    });
//});