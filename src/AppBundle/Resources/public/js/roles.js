
/**
 * Obtiene el rol indicado y arma una tabla con los permisos incluidos como rol.
 * 
 * @param string URL al controlador que devuelve el rol y sus permisos como JSON
 * @param string url_edit_rol URL a la pantalla de edicion del rol.
 * @returns {undefined}
 */
function ajaxGetRolAsJson(url_rol_as_json, url_edit_rol) {

    $.getJSON(url_rol_as_json, function (data) {
        if (typeof data === 'object') {

            var html = '<div>';

            if (data.permisos.length > 0) {
                var tabla_permisos = $('#tabla-permisos').clone();
                var tbody = tabla_permisos.find('tbody');
                $.each(data.permisos, function (key, val) {
                    var fila = '<tr>';
                    fila += "<td class='text-center'>" + val.codigo + "</td>";
                    fila += "<td>" + val.titulo + "</td>";
                    fila += "<td>" + val.descripcion + "</td>";

                    fila += '</tr>';
                    tbody.append(fila);
                });

                html = tabla_permisos.removeClass('d-none');
                html = tabla_permisos.html();

            } else {
                html += "<span class='text-muted'>No existen permisos asignados a este rol.</span>";
            }
            html += '</div>';


            var dialog = bootbox.dialog({
                title: data.titulo,
                message: html,
                size: 'large',                
                buttons: {
                    cancel: {
                        label: "Editar rol",
                        className: 'btn-outline-secondary',
                        callback: function () {                            
                            window.location.href = url_edit_rol;
                        }
                    },
                    ok: {
                        label: "Cerrar",
                        className: 'btn-primary',
                        callback: function () {
                            //console.log('Custom OK clicked');
                        }
                    }
                }
            });
            
            
            dialog.find('.modal-body').addClass('p-0');
        }
        console.log(data);

    });

}