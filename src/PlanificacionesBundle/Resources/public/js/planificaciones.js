$(document).ready(function () {

    var msg = "<p class='lead'>Para cargar los datos de esta sección debe completar los datos requeridos en la sección <em class='text-primary'>Informaci&oacute;n b&aacute;sica.</em></p>";


}
);


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

/**
 * Callback que se ejecuta en equipo docente luego de agregar un docente
 * 
 * @param {type} collection
 * @param {type} item
 * @returns {undefined}
 */
function afterAddDocente(collection, item) {
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
}
;
